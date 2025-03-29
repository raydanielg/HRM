<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\StripeInvoice;
use Yajra\DataTables\Facades\DataTables;

class SuperAdminInvoiceController extends AdminBaseController
{
    /**
     * SuperAdminInvoiceController constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->invoicesActive = 'active';
        $this->pageTitle = 'Invoices';

        $this->middleware(function ($request, $next) {
            if (admin()->type != 'superadmin') {
                echo View::make('admin.errors.noaccess', $this->data);
                exit;
            }
            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.invoices.index', $this->data);
    }

    public function ajax_invoices()
    {
        $packages = StripeInvoice::with(['company', 'plan'])->orderBy('created_at', 'desc');

        return Datatables::of($packages)

            ->editColumn('company', function ($row) {
                    return ucfirst($row->company->company_name);
            })
            ->editColumn('plan', function ($row) {
                return ucfirst($row->plan->plan_name);
            })
            ->editColumn('pay_date', function ($row) {
                return $row->pay_date->toFormattedDateString();
            })
            ->editColumn('next_pay_date', function ($row) {
                if(!is_null($row->next_pay_date)) {
                    return $row->next_pay_date->toFormattedDateString();
                }
                return '-';
            })
            ->editColumn('invoice_id', function ($row) {
                if(!is_null($row->invoice_id)) {
                    return $row->invoice_id;
                }
                return '-';
            })
            ->editColumn('transaction_id', function ($row) {
                if(!is_null($row->transaction_id)) {
                    return $row->transaction_id;
                }
                return '-';
            })
            ->make(true);
    }

}
