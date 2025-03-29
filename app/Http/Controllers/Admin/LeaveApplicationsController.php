<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\Attendance;
use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class LeaveApplicationsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->leaveApplicationOpen = 'active open';
        $this->pageTitle = trans('core.leaveApplication');
    }


    public function index()
    {
        return View::make('admin.leave_applications.index', $this->data);
    }


    //  Datatable ajax request
    public function ajaxApplications()
    {
        $result = LeaveApplication::join('employees', 'leave_applications.employee_id', '=', 'employees.id')
            ->select('leave_applications.id as id', 'employees.full_name', 'leave_applications.start_date', 'leave_applications.end_date', 'leave_applications.days', 'leave_applications.leaveType', 'leave_applications.reason', 'leave_applications.applied_on', 'leave_applications.application_status', 'leave_applications.halfDayType', 'leave_applications.created_at','employee_id')
            ->whereNotNull('leave_applications.application_status')
            ->get();


        return DataTables::of($result)->editColumn('start_date', function ($row) {
            $start = Carbon::createFromFormat("Y-m-d", $row->start_date);

            if ($row->end_date == null) {
                $end = clone $start;
            } else {
                $end = Carbon::createFromFormat("Y-m-d", $row->end_date);
            }

            $dates = $start->format("d-M-Y") . ' ' . (isset($row->end_date) ? ' to ' . $end->format("d-M-Y") : '');

            return $dates;

        })->editColumn('applied_on', function ($row) {
            return date('d-M-Y', strtotime($row->applied_on));
        })->editColumn('leaveType', function ($row) {
            $leave = $row->leaveType;

            if ($row->halfDayType == "yes") {
                $leave .= '<br/><span class="label label-info label-sm">Half Day</span>';
            }

            return $leave;

        })->editColumn('reason', function ($row) {
            return strip_tags(Str::limit($row->reason, 50));
        })->editColumn('application_status', function ($row) {
            $color = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'];

            return "<span class='label label-{$color[$row->application_status]}'>" . trans('core.' . $row->application_status) . "</span>";
        })->removeColumn('halfDayType')->removeColumn('end_date')->addColumn('edit', function ($row) {
            if ($row->application_status == 'pending') {
                $string = '
                         <div class="btn-group"><button class="btn green btn-sm margin-bottom-5" data-toggle="modal" href="#static_approve" onclick="show_approve(' . $row->id . ');return false;">' . trans('core.btnApprove') . '</button>
                         <button class="btn btn-danger btn-sm margin-bottom-5" data-toggle="modal" href="#static_reject" onclick="show_reject(' . $row->id . ');return false;" >' . trans('core.btnReject') . '</button>
                         <button class="btn purple btn-sm margin-bottom-5" data-toggle="modal" href="#static" onclick="show_application(' . $row->id . ');return false;" ><i class="fa fa-edit"></i> ' . trans('core.btnView') . '</button>
                         <a  href="javascript:;" onclick="del(' . $row->id . ');return false;" class="btn red btn-sm margin-bottom-5">
                         <i class="fa fa-trash"></i> ' . trans('core.btnDelete') . '</a></div>';
            } else {
                $string = '
                        <button class="btn purple btn-sm margin-bottom-5" data-toggle="modal" href="#static" onclick="show_application(' . $row->id . ');return false;" ><i class="fa fa-eye"></i> ' . trans('core.btnView') . '</button>
                        <a  href="javascript:;" onclick="del(' . $row->id . ');return false;" class="btn red btn-sm margin-bottom-5">
                        <i class="fa fa-trash"></i> ' . trans('core.btnDelete') . '</a>';
            }

            return $string;
        })->editColumn('full_name', function ($row) {
            $employee = Employee::find($row->employee_id);
            return $employee->decryptToCollection()->full_name;
        })
            ->removeColumn('created_at')
            ->rawColumns(['edit', 'application_status', 'reason', 'leaveType', 'applied_on', 'start_date'])
            ->make();
    }


    public function show($id)
    {
        $this->leave_application = LeaveApplication::find($id);
        return View::make('admin.leave_applications.show', $this->data);
    }


    public function update(Request $request, $id)
    {
        $check = LeaveApplication::find($id);

        if ($check == null) {
            return \View::make('admin.errors.noaccess', $this->data);
        }

        $inputs = \Input::all();
        $this->data["data"] = $inputs;

        $leave_application = LeaveApplication::findOrFail($id);

        $inputs['application_status'] = ($inputs['application_status'] == 'Approve') ? 'approved' : 'rejected';
        $leave_application->update($inputs);

        $start = Carbon::createFromFormat("Y-m-d", $leave_application->start_date);

        if ($leave_application->end_date == null) {
            $end = clone $start;
        } else {
            $end = Carbon::createFromFormat("Y-m-d", $leave_application->end_date);
        }


        $diffDays = $end->diffInDays($start);

        if ($leave_application->application_status == 'approved') {
            for ($i = 0; $i <= $diffDays; $i++) {

                $date = $start;
                $attendance = Attendance::firstOrCreate(['date' => $date->format("Y-m-d"),
                    'employee_id' => $leave_application->employee_id]);

                $attendance->leaveType = $leave_application->leaveType;
                $attendance->halfDayType = $leave_application->halfDayType;
                $attendance->reason = $leave_application->reason;
                $attendance->status = 'absent';
                $attendance->applied_on = $leave_application->applied_on;
                $attendance->last_updated_by = admin()->id;
                $attendance->application_status = 'approved';
                $attendance->save();
//                $start->addDays(1);
            }
        }


        $employee = Employee::where('id', '=', $leave_application->employee_id)->first();
        $this->email = $employee->email;

        //---- EXPENSE EMAIL TEMPLATE-----

        $this->date = ($start->format("d-M-Y")) . ' ' . (isset($leave_application->end_date) ? ' to ' . $end->format("d-M-Y") : '');
        $company = admin()->company;

        if ($company->leave_notification == 1) {
            if ($request->application_status != 'pending') {
                $emailInfo = ['from_email' => $this->setting->email,
                    'from_name' => $this->setting->name,
                    'to' => $employee->email,
                    'active_company' => $company
                ];

                $fieldValues = [
                    'NAME' => $employee->full_name,
                    'DATE' => $this->date,
                    'STATUS' => $request->application_status

                ];
                EmailTemplate::prepareAndSendEmail('LEAVE_APPROVAL', $emailInfo, $fieldValues);
                //---- EXPENSE  EMAIL TEMPLATE SENT-----
            }
        }


        Session::flash('success', trans("messages.leaveApplicationUpdateMessage"));

        return Redirect::route('admin.leave_applications.index');
    }


    public function destroy($id)
    {

        $leave_application = LeaveApplication::findOrFail($id);


        $start = Carbon::createFromFormat("Y-m-d", $leave_application->start_date);

        if ($leave_application->end_date == null) {
            $end = clone $start;
        } else {
            $end = Carbon::createFromFormat("Y-m-d", $leave_application->end_date);
        }

        $diffDays = $end->diffInDays($start);
        for ($i = 0; $i < $diffDays; $i++) {
            $date = $start->addDays(1);

            Attendance::where('date', '=', $date->format('Y-m-d'))
                ->where('employee_id', $leave_application->employee_id)
                ->delete();
        }

        LeaveApplication::destroy($id);
        $output['success'] = 'deleted';

        return Response::json($output, 200);
    }

}
