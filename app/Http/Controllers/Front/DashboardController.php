<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Http\Controllers\FrontBaseController;
use App\Http\Requests\Front\Employee\LeaveStoreRequest;
use App\Http\Requests\Front\Login\ChangePasswordRequest;
use App\Mail\LeaveRequest;
use App\Models\Admin;
use App\Models\Attendance;
use App\Models\Award;
use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\Leavetype;
use App\Models\Noticeboard;
use App\Models\Payroll;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

use Yajra\DataTables\Facades\DataTables;

class DashboardController extends FrontBaseController
{

    public function __construct()
    {

        parent::__construct();
        $this->pageTitle = trans('pages.dashboard.title');
    }


    public function index()
    {
        $this->homeActive = 'active';

        $this->noticeboards = Noticeboard::where('noticeboards.status', '=', 'active')
            ->orderBy('id', 'DESC')
            ->get();

        $this->holidays = Holiday::orderBy('date', 'ASC')->get();

        $this->attendance = Attendance::where('employee_id', '=', \employee()->id)
            ->where(function ($query) {
                $query->where('application_status', '=', 'approved')
                    ->orWhere('application_status', '=', null)
                    ->orWhere('attendance.status', '=', 'present');
            })
            ->get();

        $this->holiday_color = ['info', 'error', 'success', 'pending', ''];
        $this->holiday_font_color = ['blue', 'red', 'green', 'yellow', 'dark'];


        return View::make('front.employeeDashboard', $this->data);
    }

    public function ajax_load_calender()
    {

        $attendance = Attendance::join('employees', 'attendance.employee_id', '=', 'employees.id')
            ->where('attendance.employee_id', '=', \employee()->id)
            ->select('*', 'attendance.reason as title', 'attendance.status as a_status')
            ->where('date', '>=', Input::get('start'))
            ->where('date', '<', Input::get('end'))
            ->where(function ($query) {
                $query->where('application_status', '=', 'approved')
                    ->orwhere('application_status', '=', null)
                    ->orwhere('attendance.status', '=', 'present');
            })
            ->get()
            ->toArray();
        $attendance2 = Attendance::join('employees', 'attendance.employee_id', '=', 'employees.id')
            ->where('attendance.employee_id', '<>', \employee()->id)
            ->select('*', DB::raw('substring_index(full_name, " ", 1) as title'), 'attendance.status as a_status', DB::raw('\'absent_other\' as type'))
            ->where('date', '>=', Input::get('start'))
            ->where('date', '<', Input::get('end'))
            ->where('date', '>=', new \DateTime('today'))
            ->where('attendance.status', '=', 'absent')
            ->where(function ($query) {
                $query->where('application_status', '=', 'approved')
                    ->orwhere('application_status', '=', null);
            })
            ->get()
            ->toArray();

        $holidays = Holiday::select('holidays.id', 'holidays.occassion as title', 'holidays.date')
            ->where('date', '>=', Input::get('start'))
            ->where('date', '<', Input::get('end'))
            ->get()
            ->toArray();

        $month = strtotime(Input::get('start'));
        $start_month = date('m', $month);
        $month_end = strtotime(Input::get('end'));
        $end_month = date('m', $month_end);
        if ($start_month == 12) {
            $employees = Employee::select('employees.id', 'employees.full_name as title', 'employees.date_of_birth as date', DB::raw('\'birthday\' as type'))
                ->where(DB::raw('month(date_of_birth)'), '<=', $start_month)
                ->where(DB::raw('month(date_of_birth)'), '<', $end_month)->get()->toArray();
        } elseif ($start_month == 11) {
            $employees = Employee::select('employees.id', 'employees.full_name as title', 'employees.date_of_birth as date', DB::raw('\'birthday\' as type'))
                ->where(DB::raw('month(date_of_birth)'), '>=', $start_month)
                ->where(DB::raw('month(date_of_birth)'), '>', $end_month)->get()->toArray();
        } else {
            $employees = Employee::select('employees.id', 'employees.full_name as title', 'employees.date_of_birth as date', DB::raw('\'birthday\' as type'))
                ->where(DB::raw('month(date_of_birth)'), '>=', $start_month)
                ->where(DB::raw('month(date_of_birth)'), '<', $end_month)->get()->toArray();
        }
        if ($employees) {
            foreach ($employees as $key => $emp_bday) {
                $temp_date = strtotime($emp_bday['date']);
                $formate_1 = date('m-d', $temp_date);
                $y = Carbon::now();
                $year = $y->year;
                $new_date = $year . '-' . $formate_1;
                $employees[$key]['date'] = $new_date;
            }
        }
        $calender = array_merge($attendance, $holidays, $employees, $attendance2);

        return json_encode($calender);
    }

    //	show Salary  Page
    public function salary()
    {

        $this->salaryActive = 'active';

        return View::make('front.salary', $this->data);
    }


    public function salary_show($id)
    {

        $this->payroll = Payroll::findOrFail($id);
        $this->payslip_num = Payroll::where('payrolls.id', '<=', $id)->count();

        //echo 'test';
        return View::make('admin.payrolls.pdfview', $this->data);
    }

    public function downloadPdf($id)
    {
        $this->payroll = Payroll::findOrFail($id);
        $this->payslip_num = Payroll::where('payrolls.id', '<=', $id)->count();
        return \PDF::loadView("admin.payrolls.pdfview", $this->data)
            ->download(date('F', mktime(0, 0, 0, $this->payroll->month, 10)) . "-" . $this->payroll->year . ".pdf");
    }

    // Datatable ajax request
    public function ajax_payrolls()
    {

        $result = Payroll::select('payrolls.id', DB::raw("MONTHNAME(STR_TO_DATE(month, '%m')) as month"), 'year', 'net_salary', 'payrolls.created_at')
            ->where('payrolls.employee_id', '=', \employee()->id)
            ->orderBy('payrolls.created_at', 'desc');

        return DataTables::of($result)
            ->editColumn('created_at', function ($row) {

                return date('d-M-Y', strtotime($row->created_at));
            })
            ->addColumn('actions', function ($row) {
                return '
		                       <a  data-toggle="modal" data-target=".show_notice" class="btn-u green btn-sm margin-bottom-10" onclick="show_salary_slip(' . $row->id . ')" href="javascript:;" ><i class="fa fa-eye"></i> View</a>
		                       <a class="blue btn-u btn-sm margin-bottom-10"  href="' . route('front.payrolls.downloadpdf', $row->id) . '" ><i class="fa fa-download"></i> Download PDF</a>';

            })
            //->filter_column('month', 'whereRaw', "MONTHNAME(STR_TO_DATE(month, '%m')) like ?", ["$1"])
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function notice_ajax($id)
    {

        $notice = Noticeboard::find($id);
        $output['title'] = $notice->title;
        $output['description'] = $notice->description;

        return Response::json($output, 200);
    }




    public function changePasswordModal()
    {
        return View::make('front.change_password_modal', $this->data);
    }


    public function change_password(ChangePasswordRequest $request)
    {
        $input = Input::all();

        $employee = \employee();
        $employee->password = $input['password'];
        $employee->save();

        //---- PREPARE AND SEND EMAIL-----
        $emailInfo = [
            'from_email' => $employee->company->email,
            'from_name' => $employee->company->name,
            'to' => $employee->email,
            'active_company' => $employee->company
        ];
        $fieldValues = [
            'NAME' => $employee->full_name
        ];
        EmailTemplate::prepareAndSendEmail('CHANGE_PASSWORD_EMPLOYEE', $emailInfo, $fieldValues);
        //---- PREPARE AND SEND EMAIL-----


        return Reply::success('messages.passwordChangeSuccess');
    }
}
