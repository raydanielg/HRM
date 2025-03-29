<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;

use App\Http\Requests\Admin\Payroll\DeleteRequest;
use App\Http\Requests\Admin\Payroll\EditRequest;
use App\Http\Requests\Admin\Payroll\ShowRequest;
use App\Http\Requests\Admin\Payroll\StoreRequest;
use App\Http\Requests\Admin\Payroll\UpdateRequest;
use App\Models\Award;
use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Payroll;
use App\Models\Salary;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PayrollsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = trans("pages.payroll.indexTitle");
        $this->payrollOpen = 'active open';
        $this->payrollActive = 'active';
        $this->hrMenuActive = 'active';
    }

    public function index()
    {
        $this->employees = Employee::select('id', 'full_name', 'employeeID')
            ->where('status', '=', 'active')
            ->get();
        return View::make('admin.payrolls.index', $this->data);
    }

    // Datatable ajax request
    public function ajax_payrolls(Request $request)
    {

        $result = Employee::manager(admin()->id)
            ->join('payrolls', 'payrolls.employee_id', '=', 'employees.id')
            ->select(
                DB::raw('(@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS s_id'),
                'payrolls.id',
                'employees.employeeID as employeeID',
                'employees.full_name',
                'department.name',
                DB::raw('CONCAT(LPAD(payrolls.month,2, 0), "-", payrolls.year) as year'),
                'payrolls.net_salary',
                'payrolls.created_at',
                'payrolls.employee_id',
                'payrolls.status'
            );

        if($request->employee_id !== 'all') {
            $result = $result->where('employees.id', $request->employee_id);
        }

        return DataTables::of($result)
            ->filterColumn('year', function($query, $keyword) {
                $sql = "CONCAT(LPAD(payrolls.month,2, 0), \"-\", payrolls.year)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('created_at', function ($row) {
                return date('d-M-Y', strtotime($row->created_at));
            })
            ->editColumn('id', function () {
                static $row = 0;
                $row++;
                return $row;
            })
            ->editColumn('status', function ($row) {
                $color = ['paid' => 'success', 'unpaid' => 'danger'];

                return "<span id='status{$row->id}' class='label label-{$color[$row->status]}'>" .
                    trans("core." . $row->status) . "</span>";
            })
            ->editColumn('net_salary', function ($row) {
                return round($row->net_salary, 2);
            })
            ->addColumn('actions', '
               <a style="width: 75px;" class="btn blue-madison btn-sm margin-bottom-5"  href="{{ route(\'admin.payrolls.show\',$id)}}" ><i class="fa fa-eye"></i> {{trans("core.btnView")}}</a>
               <a style="width: 75px;" class="btn purple btn-sm margin-bottom-5"  href="{{ route(\'admin.payrolls.edit\',$id)}}" ><i class="fa fa-edit"></i> {{trans("core.edit")}}</a>
               <a class="blue-ebonyclay btn btn-sm margin-bottom-5"  href="{{ route(\'admin.payrolls.downloadpdf\',$id)}}" ><i class="fa fa-download"></i> {{trans("core.btnDownload")}} PDF</a>
               <a style="width: 75px;" href="javascript:;" onclick="del(\'{{ $id }}\');return false;" class="btn red btn-sm margin-bottom-5">
               <i class="fa fa-trash"></i> {{trans("core.btnDelete")}}</a>')
            ->editColumn('full_name', function ($row) {
                return $row->decryptToCollection()->full_name;
            })
            ->rawColumns(['actions', 'status'])
            ->make();
    }


    public function create()
    {
        $this->pageTitle = trans("pages.payroll.createTitle");
        $this->employees = Employee::manager()
            ->select('full_name', 'employees.id', 'employeeID')
            ->where('status', '=', 'active')->get();

        return View::make('admin.payrolls.create', $this->data);
    }

    public function check()
    {
        $this->payrolls = Payroll::where('employee_id', '=', Input::get('employee_id'))
            ->where('month', '=', Input::get('month'))
            ->where('year', '=', Input::get('year'))->first();
        try {
            $this->basicSalary = Salary::where('employee_id', '=', Input::get('employee_id'))
                ->where('type', '=', 'basic')->first()->salary;
        } catch (\Exception $e) {
            $this->basicSalary = 0;
        }

        try {
            $this->hourly_rate = Salary::where('employee_id', '=', Input::get('employee_id'))
                ->where('type', '=', 'hourly_rate')->first()->salary;
        } catch (\Exception $e) {
            $this->hourly_rate = 0;
        }

        if ($this->payrolls) {
            $output['success'] = 'success';

            $output['content'] = View::make('admin.payrolls.create_edit', $this->data)->render();
        } else {
            $this->expense = Expense::selectRaw('month(purchase_date) as month,year(purchase_date) as year, sum(price) as sum,employee_id')
                ->groupBy('month', 'year', 'employee_id')->orderBy('month', 'desc')
                ->where('employee_id', '=', Input::get('employee_id'))
                ->where('status', '=', 'approved')
                ->whereRaw("month(purchase_date) ='" . Input::get('month') . "'")
                ->whereRaw("year(purchase_date) ='" . Input::get('year') . "'")->get()
                ->first();

            $this->expense = isset($this->expense->sum) ? $this->expense->sum : 0;
            $monthName = date('F', mktime(0, 0, 0, Input::get('month'), 10)); // March

            $this->awardBonus = Award::selectRaw('sum(cash_price) as sum')
                ->where('employee_id', '=', Input::get('employee_id'))
                ->where('month', '=', strtolower($monthName))
                ->where('year', '=', Input::get('year'))->first();

            $this->awardBonus = isset($this->awardBonus->sum) ? $this->awardBonus->sum : 0;

            $output['success'] = 'fail';
            $output['content'] = View::make('admin.payrolls.create_add', $this->data)->render();
        }


        return Response::json($output, 200);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        $output = [];
        $deductions = [];
        $allowances = [];
        $input = $request->all();

        // Allowances
        $i = 0;
        if (isset($input['allowanceTitle'])) {
            foreach ($input['allowanceTitle'] as $title) {
                if ($title != '') {
                    $allowances[$title] = $input['allowance'][$i];
                }
                $i++;
            }
        }
        // Deductions
        $i = 0;
        if (isset($input['deductionTitle'])) {
            foreach ($input['deductionTitle'] as $title) {
                if ($title != '') {
                    $deductions[$title] = $input['deduction'][$i];
                }
                $i++;
            }
        }

        $payroll = Payroll::firstOrCreate(['employee_id' => $input['employee_id'], 'month' => $input['month'],
            'year' => $input['year'],]);

        $payroll->basic = $input['basic'];
        $payroll->overtime_hours = $input['overtime_hours'];
        $payroll->overtime_pay = $input['overtime_pay'];
        $payroll->allowances = json_encode($allowances);
        $payroll->deductions = json_encode($deductions);
        $payroll->total_deduction = $input['total_deduction'];
        $payroll->expense = $input['expense'];
        $payroll->total_allowance = $input['total_allowance'];
        $payroll->net_salary = $input['net_salary'];
        $payroll->status = $request->status;
        $payroll->save();

        if (isset($input['type'])) {
            return Reply::redirect(route('admin.payrolls.index'), 'messages.payrollUpdateMessage');
        }
        return Reply::redirect(route('admin.payrolls.index'), 'messages.payrollAddMessage');

    }


    /**
     * @param ShowRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(ShowRequest $request, $id)
    {
        $this->pageTitle = trans("pages.payroll.showTitle");

        $this->payroll = Payroll::findOrFail($id);
        $this->employee = $this->payroll->employee;
        $this->payslip_num = Payroll::where('payrolls.id', '<=', $id)->count();


        return View::make('admin.payrolls.show_pdf', $this->data);
    }

    /**
     * @param EditRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(EditRequest $request, $id)
    {
        $this->pageTitle = trans("pages.payroll.editTitle");

        $this->payroll = Payroll::find($id);

        try {
            $this->hourly_rate = Salary::where('employee_id', '=', $this->payroll->employee_id)
                ->where('type', '=', 'hourly_rate')->first()->salary;
        } catch (\Exception $e) {
            $this->hourly_rate = 0;
        }

        return View::make('admin.payrolls.edit', $this->data);
    }

    public function downloadPdf($id)
    {
        $this->payroll = Payroll::with('employee')->findOrFail($id);
        $this->employee = $this->payroll->employee;
        $this->payslip_num = Payroll::where('payrolls.id', '<=', $id)->count();
        return \PDF::loadView("admin.payrolls.pdfview", $this->data)
            ->download($this->payroll->employee_id . "-" . date('F', mktime(0, 0, 0, $this->payroll->month, 10)) . "-" . $this->payroll->year . ".pdf");
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $payroll = Payroll::findOrFail($id);

        $payroll->update($data);

        return Redirect::route('admin.payrolls.index');
    }


    public function report()
    {
        $salaries = Payroll::companywithdept($this->company_id)
            ->select('employees.employeeID', 'full_name', 'department.name', 'designation.designation', 'payrolls.basic', 'overtime_hours', 'overtime_pay', 'total_allowance', 'total_deduction', 'net_salary')
            ->where('month', '=', Input::get('month'))->where('year', '=', Input::get('year'))->get()
            ->toArray();

        //print_r($salaries);die;
        $monthName = date('F', mktime(0, 0, 0, Input::get('month'), 10)); // March
        $data = [[''], [admin()->company->company_name, '', '', '', '',],
            ['Payroll Report', '', '', ''], [''],
            ['Period:', $monthName . ',' . Input::get('year'), '', 'Printed On:', date('d/m/Y, g:i a')],
            [''],

            ['Employee ID', 'Employee Name', 'Department', 'Designation', 'Basic Salary', 'Total hours',
                'Total Hourly Payment', 'Total Allowance', 'Total Deduction', 'Net Salary'],

        ];

        foreach ($salaries as $salary) {
            $employee = Employee::where('employeeID', $salary['employeeID'])->first();
            $salary['full_name'] = $employee->decryptToCollection()->full_name;
            $data[] = array_values($salary);
        }


        Excel::create('Payroll-Report-' . $monthName . '-' . Input::get('year'), function ($excel) use ($data) {
            // Set the title
            $excel->setTitle('Awesome Website www.hrm.com');

            // Chain the setters
            $excel->setCreator(admin()->name)
                ->setCompany(admin()->company->company_name);

            // Call them separately
//            $excel->setDescription('A PaySlip Generated from http://' . admin()->company->subdomain);

            $excel->sheet('Payroll Report', function ($sheet) use ($data) {
                $sheet->mergeCells('A2:C2');
                $sheet->mergeCells('E5:F5');
                $sheet->cells('A7:J7', function ($cells) {
                    // Set black background
                    $cells->setBackground('#00d8ff');
                });
                $sheet->cells('A2:G2', function ($cells) {
                    // Set black background
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(16);
                });

                $sheet->fromArray($data, null, 'A1', false, false);
            });
        })->store('xls')->download('xls');
    }

    public function destroy(DeleteRequest $request, $id)
    {
        Payroll::destroy($id);

        return Reply::success("messages.successDelete");
    }

}
