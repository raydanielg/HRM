<?php

namespace App\Http\Controllers\Front;

use App\Classes\Files;
use App\Classes\Reply;
use App\Http\Controllers\FrontBaseController;
use App\Http\Requests\Front\Expense\ExpenseStore;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class ExpenseFrontsController extends FrontBaseController
{

    public function __construct()
    {

        parent::__construct();
        $this->pageTitle = Lang::get('core.jobTitle');
        $this->accountActive = 'active';
    }

    public function index()
    {
        $this->expenses = Expense::where('expenses.employee_id', employee()->id)->get();

        return View::make('front.expense.index', $this->data);
    }

    // Datatable ajax request
    public function ajax_expenses()
    {
        $result = Expense::select('expenses.id', 'item_name', 'purchase_from', 'purchase_date', 'bill', 'price', 'expenses.status')
            ->where('expenses.employee_id', employee()->id)
            ->orderBy('expenses.id', 'desc');

        return DataTables::of($result)->editColumn('purchase_date', function ($row) {
            return date('d-M-Y', strtotime($row->purchase_date));
        })->editColumn('bill', function ($row) {
            if(!is_null($row->bill)){
               return  '<a  href="'.$row->bill_url.'"
                                               target="_blank" class="btn btn-sm purple">File Uploaded</a>' ;
            }
            return '';

        })->editColumn('status', function ($row) {
            $color = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'];

            return "<span class='label label-{$color[$row->status]}'>{$row->status}</span>";
        })
            ->rawColumns(['status','bill'])
            ->make();
    }


    public function create()
    {
        return View::make('front.expense.create', $this->data);
    }

    /***
     * @param ExpenseStore $request
     * @return array
     * @throws \Exception
     */
    public function store(ExpenseStore $request)
    {

        $request->purchase_date = Carbon::createFromFormat('d-m-Y', $request->purchase_date)->format('Y-m-d');
        $expense = Expense::create($request->toArray());

        if ($request->hasFile('bill')) {
            $file = new Files();
            $filename = $file->upload(Input::file('bill'), 'expense/bills', null, null, false);
            $expense->bill = $filename;
            $expense->save();
        }

        return Reply::redirect(route('front.expenses.index'), "messages.expenseAddMessage");


    }


}
