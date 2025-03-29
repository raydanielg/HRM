<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\ContactRequest;
use App\Models\EmailTemplate;

use App\Models\Transaction;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;

class TransactionsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Transactions';
        $this->settingOpen = 'active open';
        $this->transactionsActive = 'active';

        if (admin()->type != 'superadmin') {
            echo View::make('admin.errors.noaccess', $this->data);
            die();
        }
    }

    public function index()
    {
        $this->transactionDef = Transaction::select('id', 'payer_id', 'payer_email', 'payment_method', 'payer_fname', 'amount', 'currency_code', 'created_at')
            ->orderBy('id', 'desc')->take(5)->get();
        $this->total = Transaction::count();
        return View::make('admin.transactions.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajax_transactions()
    {
        $result = Transaction::select('id', 'payer_id', 'payer_email', 'payment_method', 'payer_fname', 'amount', 'currency_code', 'created_at')
            ->get();

        return DataTables::of($result)->editColumn('created_at', function ($row) {
            return date('d-M-Y', strtotime($row->created_at));
        })->editColumn('amount', function ($row) {
            return $row->amount . " " . $row->currency_code;
        })->addColumn('edit', function ($row) {
            $string = '<a index  class="btn blue-ebonyclay btn-sm "  href="javascript:;" onclick="showView(' . $row->id . ');return false;" ><i class="fa fa-eye"></i> ' . trans('core.btnView') . '</a>';

            return $string;
        })->removeColumn('currency_code')->make();
    }

    public function change_status()
    {
        // Check employee Company
        $input = Input::all();
        $check = ContactRequest::find($input ['id']);

        if ($check == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        $contact = ContactRequest::findOrFail($input ['id']);
        $contact->status = $input['status'];
        $contact->save();
        $output['status'] = 'success';
        $output['msg'] = trans("messages.updateSuccess");

        return Response::json($output, 200);
    }

    public function show($id)
    {
        //Check employee Company
        $this->transaction = Transaction::find($id);
        $this->color = ['Pending' => 'warning', 'Completed' => 'success'];

        if ($this->transaction == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.transactions.show', $this->data);
    }

    /**
     * Update the specified emailtemplate in storage.
     *
     * @param  int $id
     * @return Response
     */

}
