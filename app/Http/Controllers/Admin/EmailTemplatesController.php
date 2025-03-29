<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\EmailTemplate\UpdateRequest;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;

class EmailTemplatesController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'Email Templates';
        $this->settingActive = 'active';
        $this->emailTemplateActive = 'active';

        $this->middleware(function ($request, $next) {
            if (admin()->type != 'superadmin') {
                echo View::make('admin.errors.noaccess', $this->data);
                die();
            }
            return $next($request);
        });
    }

    public function index()
    {
        $this->email_templates = EmailTemplate::all();
        $this->emailsDef = EmailTemplate::select('id', 'email_id', 'subject', 'body', 'created_at')
            ->where('email_id', '<>', 'NEW_COMPANY_NOTIFICATION_SUPERADMIN')
            ->where('email_id', '<>', 'NEW_COMPANY_REQUEST_TO_ADMIN')
            ->orderBy('created_at', 'desc')->take(5)->get();
        $this->total = EmailTemplate::count();
        return View::make('admin.email_templates.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajax_email_templates()
    {
        $result = EmailTemplate::select('id', 'email_id', 'subject', 'body', 'created_at')
            ->where('email_id', '<>', 'NEW_COMPANY_NOTIFICATION_SUPERADMIN')
            ->where('email_id', '<>', 'NEW_COMPANY_REQUEST_TO_ADMIN')
            ->where('email_id', '<>', 'INVOICE_ONE_DAY_LEFT_NOTICE')
            ->get();

        return DataTables::of($result)->editColumn('created_at', function ($row) {
            return date('d-M-Y', strtotime($row->created_at));
        })->addColumn('edit', function ($row) {

            $string = '<a style="width: 75px;" class="btn purple btn-sm margin-bottom-10"  href="javascript:;" onclick="showEdit(' . $row->id . ');return false;" >
										          <i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>';

            return $string;
        })
        ->rawColumns(['edit','body'])
        ->removeColumn('id')->make();
    }


    public function edit($id)
    {
        
        // VARIABLES ON EMAIL TEMPALTES
        $new_admin = ["##NAME##", "##COMPANY_NAME##", "##EMAIL##", "##PASSWORD##"];
        $this->data['email']['NEW_ADMIN'] = implode(" | ", $new_admin);

        $attendance_marked = ['##NAME##', '##DATE##'];
        $this->data['email']['ATTENDANCE_MARKED'] = implode(" | ", $attendance_marked);

        $award = ['##NAME##', '##AWARD##'];
        $this->data['email']['AWARD'] = implode(" | ", $award);

        $employee_add = ["##NAME##", "##COMPANY_NAME##", "##EMAIL##", "##PASSWORD##"];
        $this->data['email']['EMPLOYEE_ADD'] = implode(" | ", $employee_add);

        $expense_approval = ['##STATUS##', '##DATE##'];
        $this->data['email']['EXPENSE_APPROVAL'] = implode(" | ", $expense_approval);

        $leave_approval = ['##STATUS##', '##DATE##'];
        $this->data['email']['LEAVE_APPROVAL'] = implode(" | ", $leave_approval);

        $new_company_request_to_admin = ['##STATUS##', '##COMPANY_NAME##'];
        $this->data['email']['NEW_COMPANY_REQUEST_TO_ADMIN'] = implode(" | ", $new_company_request_to_admin);

        $new_company_noti = ['##STATUS##', '##COMPANY_NAME##'];
        $this->data['email']['NEW_COMPANY_NOTIFICATION_SUPERADMIN'] = implode(" | ", $new_company_noti);

        $new_notice = ['##NAME##', '##LINK##'];
        $this->data['email']['NEW_NOTICE'] = implode(" | ", $new_notice);

        $admin_reset_password = ['##NAME##', '##CODE_LINK##'];
        $this->data['email']['ADMIN_RESET_PASSWORD'] = implode(" | ", $admin_reset_password);

        $new_payslip = ['##NAME##', '##MONTH_YEAR##'];
        $this->data['email']['NEW_PAYSLIP'] = implode(" | ", $new_payslip);

        $reset_success = ['##NAME##'];
        $this->data['email']['RESET_PASSWORD_SUCCESS'] = implode(" | ", $reset_success);

        $reset_success = ['##NAME##', '##CODE_LINK##'];
        $this->data['email']['FRONT_RESET_PASSWORD'] = implode(" | ", $reset_success);

        $employee_password = ['##NAME##'];
        $this->data['email']['CHANGE_PASSWORD_EMPLOYEE'] = implode(" | ", $employee_password);

        $expense_claim = ['##NAME##', '##ITEM_NAME##', '##PURCHASE_FROM##',
            '##PURCHASE_DATE##', '##PRICE##'];
        $this->data['email']['EXPENSE_CLAIM'] = implode(" | ", $expense_claim);

        $job_request = ['##EMPLOYEE_NAME##', '##POSITION##', '##NAME##',
            '##EMAIL##', '##PHONE##', '##COVER_LETTER##', '#LINK'];
        $this->data['email']['JOB_APPLICATION_REQUEST'] = implode(" | ", $job_request);

        $employee_password = ['##NAME##'];
        $this->data['email']['CHANGE_PASSWORD_EMPLOYEE'] = implode(" | ", $employee_password);

        $emailVerifi = ['##NAME##', '##VERIFY_LINK##'];
        $this->data['email']['NEW_ADMIN_EMAIL_VERIFICATION'] = implode(" | ", $emailVerifi);

        $emailVerifi = ['##PRODUCT##', '##INVOICE_NUMBER##','##AMOUNT##','##DATE_GENERATED##','##DUE_DATE##'];
        $this->data['email']['LICENSE_EXPIRED'] = implode(" | ", $emailVerifi);


        //Check employee Company
        $this->email_template = EmailTemplate::find($id);

        if ($this->email_template == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.email_templates.edit', $this->data);
    }

    /**
     * Update the specified emailtemplate in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $email = EmailTemplate::findOrFail($id);
        $data = Input::all();

        $email->subject = Input::get('subject');
        $email->body = Input::get('body');
        $email->save();

        $output['status'] = 'success';
        $output['msg'] = trans("messages.updateSuccess");

        return Response::json($output, 200);
    }


}
