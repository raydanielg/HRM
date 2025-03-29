<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Files;
use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Expense\DeleteRequest;
use App\Http\Requests\Admin\Expense\EditRequest;
use App\Http\Requests\Admin\Expense\StoreRequest;
use App\Http\Requests\Admin\Expense\UpdateRequest;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Payroll;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class ExpensesController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->expensesActive = 'active';
        $this->hrMenuActive = 'active';
        $this->expensesOpen = 'active open';
        $this->pageTitle = trans('pages.expenses.indexTitle');

    }

    public function index()
    {
        return View::make('admin.expenses.index', $this->data);
    }

    //Datatable ajax request
    public function ajax_expenses()
    {
        $result = Expense::join('employees', 'expenses.employee_id', '=', 'employees.id')
            ->select(DB::raw('(@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS s_id'), 'item_name', 'purchase_from', 'purchase_date', 'full_name', 'price', 'expenses.status', 'bill', 'expenses.id','employee_id')
            ->orderBy('expenses.id', 'desc')
            ->get();

        return DataTables::of($result)
            ->editColumn('status', function ($row) {
                $color = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'];

                return "<span id='status{$row->id}' class='label label-{$color[$row->status]}'>" . trans("core." . $row->status) . "</span>";
            })->addColumn('edit', function ($row) {
                $display_accept = '';
                $display_reject = '';

                if ($row->status == 'rejected') {
                    $display_reject = 'style="display:none"';
                } elseif ($row->status == 'approved') {
                    $display_accept = 'style="display:none"';
                }

                $string = '';
                $accept = '<a ' . $display_accept . ' id="accept' . $row->id . '"  data-container="body" data-placement="top" data-original-title="Approve" href="javascript:;" onclick="changeStatus(' . $row->id . ',\'approved\');return false;" class="btn green btn-sm tooltips margin-bottom-10"><i class="fa fa-check"></i> Approve</a>';
                $reject = '<a ' . $display_reject . ' id="reject' . $row->id . '" data-placement="top" data-original-title="Reject"  href="javascript:;" onclick="changeStatus(' . $row->id . ',\'rejected\');return false;" class="btn red btn-sm tooltips margin-bottom-10"><i class="fa fa-close"></i> Reject</a>';
                $string .= '' . $accept . $reject . '';

                $string .= '<a  class="btn purple btn-sm margin-bottom-10"  onclick="loadView(\'' . route('admin.expenses.edit', $row->id) . '\')" ><i class="fa fa-edit"></i> ' . trans("core.btnViewEdit") . '</a>
	                    <a style="width: 94px" href="javascript:;" onclick="del(' . $row->id . ',\'' . $row->item_name . '\');return false;" class="btn red margin-bottom-10 btn-sm">
                        <i class="fa fa-trash"></i> ' . trans("core.btnDelete") . '</a>';

                return $string;
            })->editColumn('full_name', function ($row) {
                $employee = Employee::find($row->employee_id);
                return $employee->decryptToCollection()->full_name;
            })

            ->removeColumn('bill')
            ->rawColumns(['edit', 'status','employee_id'])
            ->make();
    }


    public function change_status(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->status = $request->status;
        $expense->save();

        return Reply::success("messages.expenseStatusChangeMessage");
    }


    public function create()
    {
        $this->pageTitle = trans('pages.expenses.createTitle');
        $this->expensesAddActive = 'active';

        $this->employees = Employee::manager()
            ->select('full_name', 'employees.id','employeeID')
            ->where('status', '=', 'active')->get();

        return View::make('admin.expenses.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     * @throws \Exception
     */
    public function store(StoreRequest $request)
    {

        $request->purchase_date = Carbon::createFromFormat('d-m-Y', $request->purchase_date)->format('Y-m-d');
        $expense = Expense::create($request->toArray());

        if ($request->hasFile('bill')) {
            $file = new Files();
            $filename = $file->upload(Input::file('bill'), 'expense/bills', null, null, false);
            $expense->bill = $filename;
            $expense->save();
        }

        return Reply::redirect(route('admin.expenses.index'), "messages.expenseAddMessage");
    }


    /**
     * @param EditRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(EditRequest $request, $id)
    {
        $this->pageTitle = trans('pages.expenses.editTitle');
        $this->employees = Employee::manager()
            ->select('full_name', 'employees.id','employeeID')
            ->where('status', '=', 'active')->get();

        $this->expense = Expense::find($id);

        return View::make('admin.expenses.edit', $this->data);
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function update(UpdateRequest $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->toArray());

        // If file is uploaded
        if ($request->hasFile('bill')) {
            $file = new Files();
            $filename = $file->upload(Input::file('bill'), 'expense/bills', null, null, false);
            $expense->bill = $filename;
        }

        $expense->save();

        return Reply::success("messages.expenseUpdateMessage");


    }

    public function download($id)
    {
        $this->payroll = Payroll::findOrFail($id);

        return PDF::loadView("admin.payrolls.pdfview", $this->data)
            ->download($this->payroll->employeeID . "-" . date('F', mktime(0, 0, 0, $this->payroll->month, 10)) . "-" . $this->payroll->year . ".pdf");
    }


    public function destroy(DeleteRequest $request, $id)
    {
        Expense::destroy($id);
        return Reply::success("messages.expenseDeleteMessage");
    }

}
