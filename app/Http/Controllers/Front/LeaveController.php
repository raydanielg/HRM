<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Http\Controllers\FrontBaseController;
use App\Http\Requests\Front\Leave\StoreRequest;
use App\Mail\LeaveRequest;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Models\Leavetype;
use App\Traits\Settings;
use Carbon\Carbon;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class LeaveController extends FrontBaseController
{
    use Settings;
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = trans('pages.leaveApplications.indexTitle');
    }

    public function index()
    {
        $this->leaveActive = 'active';

        $this->leaveTypesData = Leavetype::get();

        $row = Employee::select('employees.employeeID as employeeID',
            'profile_image', 'employees.full_name',
            \DB::raw('GROUP_CONCAT(DISTINCT a.leave_type SEPARATOR ",") as leave_types'),
            \DB::raw('GROUP_CONCAT(a.leave_count SEPARATOR ",") as leave_count'),
            'annual_leave',
            'employees.status',
            'last_absent')
            ->leftJoin(\DB::raw('(
SELECT attendance.leaveType as leave_type, COUNT(attendance.leaveType) as leave_count, attendance.employee_id, MAX(attendance.date) as last_absent
	FROM attendance INNER JOIN employees On employees.employeeID = attendance.employee_id
	 WHERE leaveType is not null
	GROUP BY attendance.leaveType, attendance.employee_id  )
as a'), "a.employee_id", "=", "employees.id")
            ->where("employees.id", $this->employeeID)
            ->groupBy("employees.id")->first();

        $this->takenLeaveTypes = explode(",", $row->leave_types);
        $this->takenLeaves = explode(",", $row->leave_count);


        return View::make('front.leave', $this->data);
    }

    //Datatable ajax request
    public function ajaxApplications()
    {

        $result = LeaveApplication::select('leave_applications.id', 'start_date', 'end_date', 'days', 'leaveType', 'reason', 'applied_on', 'application_status', 'halfDayType')
            ->whereNotNull('application_status')
            ->where("leave_applications.employee_id", $this->employee->id)
            ->orderBy('leave_applications.id', 'desc')->get();

        return \DataTables::of($result)->editColumn('start_date', function ($row) {
            return date('d/m/Y', strtotime($row->start_date)) . (isset($row->end_date) ? "<br>to<br>" . date('d/m/Y', strtotime($row->end_date)) : '');
        })->editColumn('applied_on', function ($row) {
            return date('d-M-Y', strtotime($row->applied_on));
        })->editColumn('leaveType', function ($row) {
            $leave = ($row->halfDayType == 'yes') ? 'half day -' . $row->leaveType : $row->leaveType;

            return $leave;
        })->editColumn('reason', function ($row) {
            return strip_tags(Str::limit($row->reason, 50));
        })->editColumn('application_status', function ($row) {
            $color = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'];

            return "<span class='label label-{$color[$row->application_status]} text-uppercase'>{$row->application_status}</span>";
        })->removeColumn('halfDayType')->removeColumn('end_date')
            ->addColumn('edit', function ($row) {

                return '<button  class="btn-u btn-u-xs btn-u-blue" onclick="show_application(' . $row->id . ');return false;" ><i class="fa fa-eye"></i></button>';
            })
            ->rawColumns(['start_date', 'applied_on', 'leaveType', 'reason', 'edit', 'application_status'])
            ->make();
    }

    public function create()
    {
        return View::make('front.leave.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        if ($request->leaveformType == 'date_range') {
            $data = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'days' => $request->days,
                'leaveType' => $request->leaveType,
                'reason' => !empty($request->reason) ? $request->reason : '',
            ];
            LeaveApplication::create($data);

            //For email
            $this->emailType = 'date_range';

            $this->dates = $request->start_date . ' to ' . $request->end_date;
            $this->days = $request->days;
            $this->leaveType = $request->leaveType;
            $this->reason = $request->reason;
        } // Single Date Leave
        else {
            $input = $request->all();
            $dateArray =$request->date;
            foreach ($dateArray as $key => $value) {
                $input['date'][$key] = ($input['date'][$key] != '') ?
                    Carbon::createFromFormat('d/m/Y', $input['date'][$key])->format('Y-m-d') :
                    NULL;
            }

            $dateArray = [];
            $leaveType = [];
            $reason = [];

            try {
                foreach ($request->date as $index => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $data = [
                        'start_date' => $value,
                        'end_date' => NULL,
                        'days' => 1,
                        'leaveType' => $input['leaveType'][$index],
                        'halfDayType' => (isset($input['halfleaveType'][$index]) && $input['halfleaveType'][$index] == 'yes') ? 'yes' : 'no',
                        'reason' => !empty($input['reason'][$index]) ? $input['reason'][$index] : '',
                    ];

                    LeaveApplication::create($data);
                    //For email
                    $this->emailType = 'single';
                    $dateArray[] = Carbon::createFromFormat('d/m/Y', $value)->format('d-M-Y');
                    $leaveType[] = $request->leaveType[$index];
                    $reason[] = $request->reason[$index];
                }
                $this->dates = $dateArray;
                $this->leaveType = $leaveType;
                $this->reason = $reason;
            } catch (\Exception $e) {
                Reply::error($e->getMessage());
            }
        }

//        $this->setMailConfigs();
        //        Send email to all admins
        $admins = Admin::select('email')->where('company_id', $this->employee->company_id)->get();

        $this->fromEmail = $this->appSetting->email;
        $this->fromName = $this->appSetting->main_name;
        $this->replyTo = $this->employee->company->email;

        $this->full_name = auth()->guard('employee')->user()->full_name;
        $this->email = auth()->guard('employee')->user()->email;


        \Mail::to($admins)->queue(new LeaveRequest($this->data));

        return Reply::success(trans('messages.leaveRequest'));
    }



    public function show(Request $request, $id)
    {
        $this->leave_application = LeaveApplication::find($id);
        return View::make('front.leave.show', $this->data);
    }
}
