<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Leavetype;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Attendance\UpdateRequest;
use App\Http\Requests;

/*
 * Attendance Controller of Admin Panel
 */

class AttendancesController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->attendanceOpen = 'active';
        $this->pageTitle = trans("pages.attendances.indexTitle");
    }


    /*
     * This is the view page of attendance.
     */
    public function index()
    {
        $this->viewAttendanceActive = 'active';

        /*$this->date = Carbon::now()->format('Y-m-d');

        return View::make('admin.attendances.index', $this->data);*/

        $this->attendances = Attendance::all();
        $this->viewAttendanceActive = 'active';

        $this->date = date('Y-m-d');
        $this->daysInMonth = Carbon::now()->daysInMonth;

        $this->employees = Employee::manager()
            ->select('full_name', 'employees.id','employeeID')
            ->where('status', '=', 'active')->get();


        return View::make('admin.attendances.attendance-sheet', $this->data);
    }

    /*
     * This is the view page of attendance.
     */
    public function attendanceEmployee()
    {
        $this->viewAttendanceEmployeeActive = 'active';

        $this->date = Carbon::now()->format('Y-m-d');

        return View::make('admin.attendances.index', $this->data);

    }

    public function ajax_employees()
    {

        // Using this query in front end too
        $result = Employee::manager(admin()->id)
            ->select('employees.employeeID as employeeID',
                'profile_image', 'employees.full_name as full_name',
                \DB::raw('GROUP_CONCAT(DISTINCT a.leave_type SEPARATOR ",") as leave_types'),
                \DB::raw('GROUP_CONCAT(a.leave_count SEPARATOR ",") as leave_count'),
                'annual_leave',
                'employees.status',
                'last_absent','employees.id')
            ->leftJoin(\DB::raw('(
SELECT attendance.leaveType as leave_type, COUNT(attendance.leaveType) as leave_count, attendance.employee_id, MAX(attendance.date) as last_absent
	FROM attendance INNER JOIN employees On employees.id = attendance.employee_id
	 WHERE leaveType is not null
	GROUP BY attendance.leaveType, attendance.employee_id  )
as a'), "a.employee_id", "=", "employees.id")
            ->groupBy("employees.employeeID");

        $leaveTypes = Leavetype::pluck("leaveType");


        return DataTables::of($result)
            ->addColumn('edit', function ($row) {

                $string = ' <a class="btn purple btn-sm" href="' . route('admin.attendances.show', $row->id) . '">
                                        <i class="fa fa-eye"></i> ' . trans("core.view") . ' </a>';

                return $string;
            })
            ->editColumn('status', function ($row) {
                $color = ['active' => 'success', 'inactive' => 'danger'];

                return "<span id='status{$row->id}' class='label label-{$color[$row->status]}'>" . trans("core." . $row->status) . "</span>";
            })
            ->editColumn('last_absent', function ($row) {
                if ($row->last_absent == null) {
                    return '<span class="label label-success">Never</span>';
                } else {
                    $carbon = Carbon::createFromFormat("Y-m-d", $row->last_absent);

                    return $carbon->format("d-M-Y") . " (" . $carbon->diffForHumans() . ")";
                }
            })
            ->editColumn('leave_types', function ($row) use ($leaveTypes) {
                $takenLeaveTypes = explode(",", $row->leave_types);
                $takenLeaves = explode(",", $row->leave_count);

                $data = '<table width="100%">';
                foreach ($leaveTypes as $leaveType) {
                    $data .= ' <tr>';
                    $data .= '<td ><strong>' . ucfirst($leaveType) . '</strong>: </td>';

                    if (($key = array_search($leaveType, $takenLeaveTypes)) !== FALSE) {
                        $data .= '<td>' . $takenLeaves[$key] . '</td>';
                    } else {
                        $data .= '<td>0</td>';
                    }
                    $data .= '</tr>';
                }
                $data .= '</table>';

                return $data;
            })
            ->editColumn('profile_image', function ($employee) {
                return \HTML::image($employee->profile_image_url, 'ProfileImage', ['height' => '80px']);

            })
            ->editColumn('employeeID', function ($employee) {
                return $employee->employeeID;
            })->editColumn('full_name', function ($row) {
                $employee = Employee::find($row->id);
                return $employee->decryptToCollection()->full_name;
            })

            ->removeColumn('id')
            ->rawColumns(['profile_image', 'leave_types', 'last_absent', 'status', 'edit'])
            ->make(true);
    }

    /**
     * @return mixed
     * This method is called when we mark the attendance and redirects to edit page.
     */

    public function create()
    {
        $date = Carbon::now()->timezone(admin()->timezone)->format("Y-m-d");

        $attendance_count = Attendance::where('date', '=', $date)
            ->count();
        $employee_count = Employee::where('status', '=', 'active')
            ->count();

        if ($employee_count == $attendance_count && ($attendance_count)>0) {
            if (!\Session::get('success')) {
                \Session::flash('success', trans("messages.attendanceAlreadyMarked"));
            }
        } else {
            \Session::forget('success');
        }

        return \Redirect::route('admin.attendances.edit', $date);
    }


    /**
     * Display the specified attendance
     */
    public function show($id)
    {
        $this->employee = Employee::findOrFail($id);
        if ($this->employee == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        $this->viewAttendanceActive = 'active';


        $this->attendance = Attendance::where('employee_id', '=', $id)->where(function ($query) {
            $query->where('application_status', '=', 'approved')
                ->orwhere('application_status', '=', null)
                ->orwhere('status', '=', 'present');
        })->get();

        $this->holidays = Holiday::get();

        $this->employeeslist = Employee::manager()
            ->select('full_name', 'employees.id','employeeID')
            ->where('status', '=', 'active')->get();

        return View::make('admin.attendances.show', $this->data);
    }

    /**
     * Show the form for editing the specified attendance.
     */
    public function edit($date_str)
    {
        $dateObj = Carbon::createFromFormat("Y-m-d", $date_str, $this->data["setting"]->timezone)->timezone('UTC');
        $date = $dateObj->format("Y-m-d");

        $this->markAttendanceActive = 'active';

        $attendanceArray = [];
        $this->attendance = Employee::manager(admin()->id)
            ->leftJoin("attendance", function ($query) use ($date) {
                $query->on("attendance.employee_id", "=", "employees.employeeID");
                $query->on("attendance.date", "=", \DB::raw('"' . $date . '"'));
            })
            ->select('employees.full_name',
                'employees.employeeID as employeeID',
                'attendance.status',
                'attendance.date',
                'attendance.leaveType',
                'attendance.halfDayType',
                'attendance.application_status',
                'attendance.applied_on',
                'attendance.clock_in',
                'attendance.clock_out',
                'attendance.clock_in_ip_address',
                'attendance.clock_out_ip_address',
                'attendance.working_from',
                'attendance.notes',
                'attendance.reason',
                'attendance.is_late'
            )
            ->where("employees.status", "active")
            ->take(10)
            ->get();

        $this->todays_holidays = Holiday::where('date', '=', $date)
            ->get()
            ->first();

        foreach ($this->attendance as $attend) {
            $attendanceArray[$attend['employeeID']] = $attend;
        }

        $this->date = $dateObj->timezone(admin()->company->timezone);
        $this->attendanceArray = $attendanceArray;
        $this->leaveTypes = Attendance::leaveTypesEmployees($this->company_id);

        $this->data["employees_count"] = Employee::count();
        $this->officeStartTime = Carbon::createFromFormat('H:i:s', admin()->company->office_start_time, 'UTC')->timezone(admin()->company->timezone)->format('g:i A');
        $this->timeZoneLocal = admin()->company->timezone;
        $this->officeEndTime = Carbon::createFromFormat('H:i:s', admin()->company->office_end_time, 'UTC')->timezone(admin()->company->timezone)->format('g:i A');

        return \View::make('admin.attendances.edit', $this->data);
    }

    /**
     * Update the specified attendance in storage.
     */
    public function update($date_str)
    {
        $date = Carbon::parse($date_str)->format("Y-m-d");

        $data = json_decode(Input::get("data"), true);
        $employeeIDs = array_keys($data);

        \DB::beginTransaction();

        // Get all employee ids for this company

        $allEmployeeIDs = Employee::pluck("id");

        try {
            foreach ($allEmployeeIDs as $employeeID) {

                /** @var Attendance $attendance */
                $attendance = Attendance::firstOrCreate(['employee_id' => $employeeID, 'date' => $date]);

                if (in_array($employeeID, $employeeIDs)) {

                    // If employee's leave is approved but admin marks him present, then we remove his leave and mark him present
                    if ($attendance->application_status != 'approved' || ($attendance->application_status == 'approved' && $data[$employeeID]["status"] == 'true')) {

                        // We separately set all parameters for present and absent
                        // so that previously set values are overwritten. For example,
                        // if a person was marked present for a day but then he was updated as absent
                        // then his clocking details should be null to prevent wrong calculations
                        if ($data[$employeeID]["status"] == "true") {
                            $attendance->status = "present";
                            $attendance->leaveType = null;
                            $attendance->halfDayType = null;
                            $attendance->reason = '';
                            $attendance->application_status = null;

                            $clock_in = Carbon::createFromFormat('g:i A', $data[$employeeID]["clock_in"], admin()->company->timezone)
                                ->timezone('UTC');
                            $clock_out = Carbon::createFromFormat('g:i A', $data[$employeeID]["clock_out"], admin()->company->timezone)
                                ->timezone('UTC');

                            // When admin is updating, late mark should not be according to clock in/clock out

                            if ($data[$employeeID]["late"] == "true") {
                                $attendance->is_late = 1;
                            } else {
                                $attendance->is_late = 0;
                            }

                            $attendance->clock_in = $clock_in->format('H:i:s');
                            $attendance->clock_out = $clock_out->format('H:i:s');
                            $attendance->working_from = "Office";
                            $attendance->notes = "";
                        } else {
                            $attendance->status = "absent";
                            $attendance->leaveType = $data[$employeeID]["leaveType"];
                            $attendance->halfDayType = ($data[$employeeID]["halfDay"] == 'true') ? 'yes' : 'no';
                            $attendance->reason = $data[$employeeID]["reason"];
                            $attendance->application_status = null;
                            $attendance->is_late = 0;

                            $attendance->clock_in = null;
                            $attendance->clock_out = null;
                            $attendance->working_from = "";
                            $attendance->notes = "";
                        }

                        $attendance->office_start_time = admin()->company->office_start_time;
                        $attendance->office_end_time = admin()->company->office_end_time;
                        $attendance->last_updated_by = admin()->id;

                        $attendance->save();
                    }
                } else {
                    if ($attendance->status != "absent") {
                        $attendance->status = "present";
                        $attendance->leaveType = null;
                        $attendance->halfDayType = null;
                        $attendance->reason = '';
                        $attendance->application_status = null;
                        $attendance->last_updated_by = admin()->id;

                        $attendance->is_late = 0;

                        $attendance->clock_in = $this->data["active_company"]->office_start_time;
                        $attendance->clock_out = $this->data["active_company"]->office_end_time;
                        $attendance->office_start_time = admin()->company->office_start_time;
                        $attendance->office_end_time = admin()->company->office_end_time;
                        $attendance->clock_in_ip_address = null;
                        $attendance->clock_out_ip_address = null;
                        $attendance->working_from = 'Office';
                        $attendance->notes = '';
                        $attendance->save();
                    }
                }
            }
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        \DB::commit();

        $this->date = Carbon::parse($date_str)->format("d M Y");

        if (admin()->company->attendance_notification == 1) {

            $employees = Employee::select('email', 'full_name')
                ->where('status', '=', 'active')
                ->get();

            //---- Attendance Marked EMAIL TEMPLATE-----

            // Do not send email notifications if there are more than x employees in database
            if ($employees->count() <= EmployeesController::$MAX_EMPLOYEES) {
                foreach ($employees as $employee) {
                    $email = "{$employee->email}";
                    $emailInfo = ['from_email' => $this->setting->email,
                        'from_name' => $this->setting->name,
                        'to' => $email,
                        'active_company' => admin()->company];
                    $fieldValues = ['NAME' => $employee->full_name, 'DATE' => $this->date];
                    EmailTemplate::prepareAndSendEmail('ATTENDANCE_MARKED', $emailInfo, $fieldValues);
                }
            }
            //---- Attendance Marked EMAIL TEMPLATE-----


        }

        return ["status" => "success",
            "message" => trans("messages.attendanceUpdateMessage", ["attendance" => date('d M Y', strtotime($date))]),
            'toastrHeading' => trans('messages.success'),
            'toastrMessage' => trans("messages.attendanceUpdateMessage", ["attendance" => date('d M Y', strtotime($date))]),
            'toastrType' => 'success',
            'action' => 'showToastr',
            'date' => $date];
    }

    public function report()
    {
        $month = Input::get('month');
        $year = Input::get('year');
        $employeeID = Input::get('employee_id');
        $firstDay = $year . '-' . $month . '-01';
        $presentCount = Attendance::countPresentDays($month, $year, $employeeID);
        $totalDays = date('t', strtotime($firstDay));
        $holidaycount = count(DB::select(DB::raw("SELECT * FROM holidays WHERE MONTH(date)=" . $month . "  AND YEAR(date)=" . $year . " AND company_id=" . $this->company_id)));
        $workingDays = $totalDays - $holidaycount;
        $percentage = ($presentCount / $workingDays) * 100;

        $output['success'] = 'success';
        $output['presentByWorking'] = "{$presentCount}/$workingDays";
        $output['attendancePerReport'] = number_format((float)$percentage, 2, '.', '');

        return Response::json($output, 200);
    }

    /**
     * Remove the specified attendance from storage.
     */
    public function destroy($id)
    {
        Attendance::destroy($id);

        return Redirect::route('admin.attendances.index');
    }

    /**
     *Updates the single Row Attendance
     *
     */
    public function updateAttendanceRow(UpdateRequest $request)
    {
        $input = $request->all();

        $date = Carbon::createFromFormat("d-m-Y", $input['date'])->timezone(admin()->company->timezone)->timezone('UTC')->format('Y-m-d');

        /** @var Attendance $attendance */
        $attendance = Attendance::firstOrCreate(['employee_id' => Input::get('id'), 'date' => $date]);

        if ($attendance->application_status != 'approved' || ($attendance->application_status == 'approved' && $input['status'] == 'present')) {
            if ($input['status'] == 'present') {
                $attendance->status = 'present';
                $attendance->leaveType = null;
                $attendance->halfDayType = "no";

                $clock_in = Carbon::createFromFormat('g:i A', Input::get('clock_in'), admin()->company->timezone)->timezone('UTC');
                $clock_out = Carbon::createFromFormat('g:i A', Input::get('clock_out'), admin()->company->timezone)->timezone('UTC');

                $attendance->clock_in = $clock_in->format('H:i:s');
                $attendance->clock_out = $clock_out->format('H:i:s');

                if ($input["is_late"] == "true") {
                    $attendance->is_late = 1;
                } else {
                    $attendance->is_late = 0;
                }

                $clock_in_ip = Input::get('clock_in_ip');
                $clock_out_ip = Input::get('clock_out_ip');
                $working_from = Input::get('work');
                $notes = Input::get('notes');

                if ($clock_in_ip != 'Not Set') {
                    $attendance->clock_in_ip_address = $clock_in_ip;
                }

                if ($clock_out_ip != 'Not Set') {
                    $attendance->clock_out_ip_address = $clock_out_ip;
                }

                $attendance->working_from = $working_from;
                $attendance->notes = $notes;
            } else {
                $attendance->status = 'absent';

                if ($input['half_day'] == 'true') {
                    $attendance->halfDayType = "yes";
                } else {
                    $attendance->halfDayType = "no";
                }

                $attendance->leaveType = Input::get('leave_type');

                $attendance->reason = $input['reason'];

                $attendance->clock_in = null;
                $attendance->clock_out = null;
                $attendance->is_late = 0;
                $attendance->clock_in_ip_address = null;
                $attendance->clock_out_ip_address = null;
                $attendance->working_from = "";
                $attendance->notes = "";
            }

            $attendance->last_updated_by = admin()->id;
            $attendance->office_start_time = admin()->company->office_start_time;
            $attendance->office_end_time = admin()->company->office_end_time;

            $attendance->save();

            return [
                'status' => 'success',
                'toastrMessage' => trans('messages.successUpdate'),
                'toastrHeading' => trans('messages.success'),
                'action' => 'showToastr',
                'checkbox' => $attendance->is_late,
                'divHTML' => \View::make("admin.attendances.col3", ["row" => $attendance])->render()
            ];

        }
        return [
            'status' => 'fail',
            'msg' => "Failed in outer loop",
            'toastrMessage' => trans('messages.successUpdate'),
            'toastrHeading' => trans('messages.success'),
            'toastrType' => 'error',
            'action' => 'showToastr',
            'divHTML' => \View::make("admin.attendances.col3", ["row" => $attendance])->render()
        ];
    }


    public function ajax_attendance(Request $request)
    {
        if ($request->has('date')) {
            $date = Carbon::parse(Input::get('date'))->format('Y-m-d');
        } else {
            $date = Carbon::now()->format('Y-m-d');
        }
        $leaveTypes = Attendance::leaveTypesEmployees($this->company_id);
        $result = Employee::manager(admin()->id)
            ->leftJoin("attendance", function ($query) use ($date) {
                $query->on("attendance.employee_id", "=", "employees.id");
                $query->on("attendance.date", "=", \DB::raw('"' . $date . '"'));
            })
            ->select('employees.full_name as full_name',
                'employees.id as employeeID',
                'attendance.status',
                'attendance.date',
                'attendance.leaveType',
                'attendance.halfDayType',
                'attendance.application_status',
                'attendance.applied_on',
                'attendance.clock_in',
                'attendance.clock_out',
                'attendance.clock_in_ip_address',
                'attendance.clock_out_ip_address',
                'attendance.working_from',
                'attendance.notes',
                'attendance.reason',
                'attendance.is_late',
                'employees.id',
                'employees.employeeID as eID'
            )
            ->where("employees.status", "active")
            ->get();
        return DataTables::of($result)
            ->editColumn('eID', function ($row) {
                return $row->eID . "</strong><p>" . $row->full_name . "</p></td>";
            })
            ->editColumn('status', function ($row) use ($leaveTypes) {
                return \View::make("admin.attendances.col2", ["row" => $row, "leaveTypes" => $leaveTypes])->render();
            })
            ->editColumn('date', function ($row) {

                $attendance_mark = \View::make("admin.attendances.col3", ["row" => $row])->render();

                return $attendance_mark;
            })
            ->editColumn('clock_in', function ($row) {

                if ($row->clock_in != null) {
                    $input_value_clock_in = Carbon::createFromFormat('H:i:s', $row->clock_in, 'UTC')->timezone(admin()->company->timezone)->format('g:i A');
                } else {
                    $input_value_clock_in = Carbon::createFromFormat('H:i:s', admin()->company->office_start_time, 'UTC')->timezone(admin()->company->timezone)->format('g:i A');
                }

                if ($row->clock_out != null) {
                    $input_value_clock_out = Carbon::createFromFormat('H:i:s', $row->clock_out, 'UTC')->timezone(admin()->company->timezone)->format('g:i A');
                } else {
                    $input_value_clock_out = Carbon::createFromFormat('H:i:s', admin()->company->office_end_time, 'UTC')->timezone(admin()->company->timezone)->format('g:i A');
                }

                return \View::make("admin.attendances.col4", [
                    "row" => $row, "clock_in" => $input_value_clock_in,
                    "clock_out" => $input_value_clock_out])->render();
            })
            ->addColumn('action', function ($row) {
                return '<button type="button" class="btn blue btn-sm" id="update_row' . $row->id . '" onclick="attendanceRow(\'' . $row->id . '\')"><i class="fa fa-check"></i></button>';
            })
            ->removeColumn('leaveType')
            ->removeColumn('id')
            ->removeColumn('halfDayType')
            ->removeColumn('application_status')
            ->removeColumn('applied_on')
            ->removeColumn('clock_out')
            ->removeColumn('clock_in_ip_address')
            ->removeColumn('clock_out_ip_address')
            ->removeColumn('is_late')
            ->removeColumn('reason')
            ->removeColumn('notes')
            ->removeColumn('working_from')
            ->rawColumns(['eID', 'status', 'date', 'clock_in', 'action'])
            ->make();
    }

    public function filterAttendance(Request $request)
    {
        $employees = Employee::with(['attendance' => function($query) use($request) {
            $query->whereRaw('MONTH(date) = ?', [$request->month])->whereRaw('YEAR(date) = ?', [$request->year]);
        }]);

        if($request->employee_id == 'all') {
            $employees = $employees->get();
        } else {
            $employees = $employees->where('id', $request->employee_id)->get();
        }

        $final = [];

        $this->daysInMonth = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);

        foreach($employees as $employee) {
            $final[$employee->id.'#'.$employee->full_name] = array_fill(1, $this->daysInMonth, '-');

            foreach($employee->attendance as $attendance) {
                $final[$employee->id.'#'.$employee->full_name][Carbon::parse($attendance->date)->day] =
                    ($attendance->status == 'absent') ?
                        '<i class="fa fa-close text-danger"></i>' :
                        '<i class="fa fa-check text-success"></i>';

            }
        }

        $this->employeeAttendence = $final;

        $view = View::make('admin.attendances.load', $this->data)->render();

        return Reply::successWithDataNew($view);
    }

}
