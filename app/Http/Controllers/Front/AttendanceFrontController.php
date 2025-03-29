<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Holiday;
use Carbon\Carbon;
use DebugBar\DebugBar;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\FrontBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class AttendanceFrontController extends FrontBaseController
{
    public function __construct()
    {
        parent::__construct();


        $this->pageTitle = Lang::get('core.attendance');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if ($this->setting->attendance_setting_set != 1) {
            \App::abort('403', 'Not Authorised');
        }
        $this->attendanceActive = 'active';

        // Creating date objects
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();

        // Office start and end times
        /** @var Carbon $end_time */
        $end_time = $this->setting->getOfficeEndTime($today);

        /** @var Carbon $start_time */
        $start_time = $this->data["setting"]->getOfficeStartTime($today);

        // Yesterday office start time
        /** @var Carbon $yesterday_end_time */
        $yesterday_end_time = clone $this->setting->getOfficeEndTime($yesterday);
        $yesterday_end_time->subDay();

        /** @var Carbon $yesterday_start_time */
        $yesterday_start_time = clone $this->data["setting"]->getOfficeStartTime($yesterday);
        $yesterday_start_time->subDay();

        // Today and yesterday dates
        $dates = [$today->format("Y-m-d"), $yesterday->format("Y-m-d")];

        $today_attendance = Attendance::where('date', $dates[0])
            ->where('employee_id', '=', employee()->id)
            ->orderBy('date')
            ->first();

        $yesterday_attendance = Attendance::where('date', $dates[1])
            ->where('employee_id', '=', employee()->id)
            ->orderBy('date')
            ->first();

        $working_attendance = null;

        // If less than 6 hours have passed since yesterday's office end time,
        // allow clocking for yesterday

        if ($today->diffInHours($yesterday_end_time) <= 6) {
            $working_attendance = $yesterday_attendance;
            $working_end_time = $yesterday_end_time;
        } else {
            $working_attendance = $today_attendance;
            $working_end_time = $end_time;
        }

        // Check today's attendance
        if ($working_attendance != null) {
            if ($working_attendance->status == "absent") {
                $this->set_attendance = 3;
            } else {
                if ($working_attendance->clock_in != null) {
                    if ($working_attendance->clock_out != null) {
                        $this->set_attendance = 0;
                        $this->clock_set = 0;
                        $this->clock_in_time = $working_attendance->clock_in->timezone($this->setting->timezone);
                        $this->clock_out_time = $working_attendance->clock_out->timezone($this->setting->timezone);
                    } else {
                        $this->clock_set = 1;
                        $this->clock_in_time = $working_attendance->clock_in->timezone($this->setting->timezone);
                        $this->set_attendance = 1;
                    }
                } else {

                    $this->clock_set = 0;
                    $this->set_attendance = 1;

                }
                $this->notes = $working_attendance->notes;
                $this->working_from = $working_attendance->working_from;
            }
        } else {
            if ($today > $working_end_time) {
                // Cannot clock in after office hours
                $this->clock_set = 0;
                $this->set_attendance = 2;
            } else {
                $this->set_attendance = 1;
                $this->clock_set = 0;
                $this->notes = '';
                $this->working_from = '';
            }

        }

        $this->local_time = Carbon::now(new \DateTimeZone($this->setting->timezone));
        $this->ip_address = $_SERVER['REMOTE_ADDR'];

        return \View::make('front.attendance.index', $this->data);
    }

    /**
     * @return array
     */
    public function clockIn()
    {
        // Creating date objects
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();

        // Yesterday office start time
        /** @var Carbon $yesterday_end_time */
        $yesterday_end_time = clone $this->setting->getOfficeEndTime($yesterday);
        $yesterday_end_time->subDay();

        /** @var Carbon $yesterday_start_time */
        $yesterday_start_time = clone $this->data["setting"]->getOfficeStartTime($yesterday);
        $yesterday_start_time->subDay();

        // Today and yesterday dates
        $dates = [$today->format("Y-m-d"), $yesterday->format("Y-m-d")];

        $today_attendance = Attendance::where('date', $dates[0])
            ->where('employee_id', '=', employee()->id)
            ->orderBy('date')
            ->first();

        $yesterday_attendance = Attendance::where('date', $dates[1])
            ->where('employee_id', '=', employee()->id)
            ->orderBy('date')
            ->first();

        $working_attendance = null;

        // If less than 6 hours have passed since yesterday's office end time,
        // allow clocking for yesterday

        if ($today->diffInHours($yesterday_end_time) <= 6) {
            $working_attendance = $yesterday_attendance;
            $working_day = $yesterday;
        } else {
            $working_attendance = $today_attendance;
            $working_day = $today;
        }

        $cur_time = $today->format('H:i:s');
        $time = Carbon::now(new \DateTimeZone($this->setting->timezone))->format('h:i A');
        $date_time = Carbon::now(new \DateTimeZone($this->setting->timezone))->format("Y-m-d H:i:s");

        // Check today's attendance
        if ($working_attendance != null) {
            if ($working_attendance->status == "absent") {
                return Reply::error( 'You have been marked absent for today');
            }
            $working_attendance->clock_in = $cur_time;
            $working_attendance->clock_in_ip_address = $_SERVER['REMOTE_ADDR'];
            $working_attendance->status = 'present';
            $working_attendance->notes = Input::get('notes');
            $working_attendance->working_from = Input::get('work_from');
            $working_attendance->office_start_time = $this->setting->office_start_time;
            $working_attendance->office_end_time = $this->setting->office_end_time;

            if ($this->setting->late_mark_after != null) {
                if ($working_attendance->clock_in->diffInMinutes($this->setting->getOfficeStartTime($working_day)) <
                    $this->setting->late_mark_after * -1) {
                    $working_attendance->is_late = 1;
                } else {
                    $working_attendance->is_late = 0;
                }
            }

            $working_attendance->save();
            return Reply::successWithData( 'You have successfully clocked in.',['time' => $time, 'timeDiff' => $working_day->diffForHumans(), 'time_date' => $date_time]);
        }
        $new_attendance = new Attendance();
        $new_attendance->employee_id = employee()->id;
        $new_attendance->date = $working_day->format("Y-m-d");
        $new_attendance->status = 'present';
        $new_attendance->clock_in = $cur_time;
        $new_attendance->clock_in_ip_address = $_SERVER['REMOTE_ADDR'];
        $new_attendance->notes = Input::get('notes');
        $new_attendance->working_from = Input::get('work_from');
        $new_attendance->office_start_time = $this->setting->office_start_time;
        $new_attendance->office_end_time = $this->setting->office_end_time;

        if ($this->setting->late_mark_after != null) {
            if ($new_attendance->clock_in->diffInMinutes($this->setting->getOfficeStartTime($working_day), false) <
                $this->setting->late_mark_after * -1) {
                $new_attendance->is_late = 1;
            } else {
                $new_attendance->is_late = 0;
            }
        }

        $new_attendance->save();
        return Reply::successWithData( 'You have successfully clocked in.',['time' => $time, 'timeDiff' => $working_day->diffForHumans(), 'time_date' => $date_time]);
    }

    function clockOut()
    {
        // Creating date objects
        $today = Carbon::now();
        $yesterday = Carbon::yesterday();

        // Yesterday office start time
        /** @var Carbon $yesterday_end_time */
        $yesterday_end_time = clone $this->setting->getOfficeEndTime($yesterday);
        $yesterday_end_time->subDay();

        /** @var Carbon $yesterday_start_time */
        $yesterday_start_time = clone $this->data["setting"]->getOfficeStartTime($yesterday);
        $yesterday_start_time->subDay();

        // Today and yesterday dates
        $dates = [$today->format("Y-m-d"), $yesterday->format("Y-m-d")];

        $today_attendance = Attendance::where('date', $dates[0])
            ->where('employee_id', '=', employee()->id)
            ->orderBy('date')
            ->first();

        $yesterday_attendance = Attendance::where('date', $dates[1])
            ->where('employee_id', '=', employee()->id)
            ->orderBy('date')
            ->first();

        $working_attendance = null;

        // If less than 6 hours have passed since yesterday's office end time,
        // allow clocking for yesterday

        if ($today->diffInHours($yesterday_end_time) <= 6) {
            $working_attendance = $yesterday_attendance;
        } else {
            $working_attendance = $today_attendance;
        }

        $cur_time = $today->format('H:i:s');

        // Check today's attendance
        if ($working_attendance != null) {
            if ($working_attendance->status == "absent") {
                return Reply::error('You have been marked absent for today');
            }
            if ($working_attendance->clock_in != null) {

                if ($working_attendance->clock_out != null) {
                    return Reply::error('Your attendance for today has already been marked');
                }
                $working_attendance->clock_out = $cur_time;
                $working_attendance->clock_out_ip_address = $_SERVER['REMOTE_ADDR'];
                $working_attendance->save();

                $clock_out = Carbon::now(new \DateTimeZone($this->setting->timezone));

                return Reply::successWithData( 'Clock out time was set successfully', ['unset_time' => $clock_out->format("h:i A"), 'unset_time_diff' => $clock_out->diffForHumans(), 'date_time' => $clock_out->format('Y-m-d H:i:s')]);

            }

            return Reply::error('You have to clock in first');
        }
        return Reply::error('You have to clock in first');

    }

    public function ajax_attendance(Request $request)
    {
        $data_table = Attendance::select(DB::raw('(@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS s_id'), 'date', 'status', 'clock_in', 'clock_out', "application_status")
            ->where('employee_id', '=', employee()->id);

        if ($request->has('from_date') && $request->has('to_date')) {
            $from_date = Carbon::parse($request->input('from_date'))->format('Y-m-d');
            $to_date = Carbon::parse($request->input('to_date'))->format('Y-m-d');

            $data_table = $data_table->whereBetween('date', [$from_date, $to_date]);
        } elseif ($request->has('from_date')) {
            $from_date = Carbon::parse($request->input('from_date'))->format('Y-m-d');
            $data_table = $data_table->where('date', '>', $from_date);
        } elseif ($request->has('to_date')) {
            $to_date = Carbon::parse($request->input('to_date'))->format('Y-m-d');
            $data_table = $data_table->where('date', '<', $to_date);
        }

        $data_table = $data_table->orderBy('date', 'desc')->get();

        return DataTables::of($data_table)->editColumn('clock_in', function ($row) {

            if ($row->clock_in == null) {
                return "-";
            }

            $clock_in = $row->clock_in->timezone($this->setting->timezone)->format('h:i A');

            return $clock_in;

        })->editColumn('clock_out', function ($row) {

            /** @var Carbon $clock_in */
            $clock_in = $row->clock_in;

            if ($clock_in == null || $row->status == "absent") {
                return "-";
            }

            /** @var Carbon $office_end_time */
            $office_end_time = $this->setting->getOfficeEndTime($row->date);

            /** @var Carbon $office_start_time */
            $office_start_time = $this->setting->getOfficeStartTime($row->date);

            /** @var Carbon $clock_out */
            $clock_out = $row->clock_out;

            $now = Carbon::now();

            if ($clock_in < $office_start_time) {
                $clock_in_time = $office_start_time;
            } else {
                $clock_in_time = $clock_in;
            }

            if ($office_start_time->diffInMinutes($clock_in, false) > 0) {
                $late_min = $office_start_time->diffInMinutes($clock_in);
            } else {
                $late_min = 0;
            }

            if ($row->clock_out == null) {
                if ($now > $office_end_time) {
                    $clock_out_time = $office_end_time;
                } else {
                    $clock_out_time = Carbon::now();
                }
            } elseif ($clock_out > $office_end_time) {
                $clock_out_time = $office_end_time;
            } else {
                $clock_out_time = $clock_out;
            }

            $clock_min = $clock_in_time->diffInMinutes($clock_out_time, false);
            $total_min = $office_start_time->diffInMinutes($office_end_time, false);

            $clock_min = ($clock_min >= 0) ? $clock_min : 0;
            $late_min = ($late_min >= 0) ? $late_min : 0;

            $clock_per = ($clock_min / $total_min) * 100;
            $late_per = ($late_min / $total_min) * 100;

            if ($row->clock_out != null) {
                $clock_out_display = Carbon::parse($row->clock_out)
                    ->timezone($this->setting->timezone)
                    ->format('g:i A');
            } else {
                $clock_out_display = '-';
            }

            return '<div class="row" style="margin-right: 0px;margin-left: 0px;">
                            <div class="pull-left">
                                <label class="control-label">Clock In :</label> ' . Carbon::parse($row->clock_in)
                    ->timezone($this->setting->timezone)
                    ->format('g:i A') . '
                            </div>
                            <div class="pull-right">
                                <label class="control-label">Clock Out :</label> ' . $clock_out_display . '
                            </div>
                            </div>
                            <div class="row" style="margin-right: 0px;margin-left: 0px;">
                            <div class="progress progress-u progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: ' . round($late_per) . '%">
                                    <span class="sr-only">' . round($late_per) . '% Complete</span>
                                </div>
                                <div class="progress-bar progress-bar-success" style="width: ' . round($clock_per) . '%">
                                    <span class="sr-only">' . round($clock_per) . '% Complete</span>
                                </div>
                            </div>
                            </div>
                        ';
        })->editColumn('date', function ($row) {

            $date = Carbon::parse($row->date)->timezone($this->setting->timezone)->format(' jS  F Y');

            return $date;
        })->editColumn('status', function ($row) {
            if ($row->clock_in == NULL) {
                $holiday = Holiday::where('date', '=', $row->date)
                    ->where('company_id', '=', $this->company_id)
                    ->first();
                if (!empty($holiday)) {
                    return '<span class="label label-info">Holiday</span>';
                } else if ($row->application_status != null) {
                    return "<span class=\"label label-warning\">On Leave</span>";
                } else {
                    return "<span class=\"label label-danger\">Absent</span>";
                }
            } else {
                return "<span class=\"label label-success\">" . ucfirst($row->status) . "</span>";
            }
        })->addColumn('Hours', function ($row) {

            $clock_in = $row->clock_in;

            if ($clock_in == null || $row->status == "absent") {
                return "-";
            }

            $office_end_time = $this->setting->getOfficeEndTime($row->date);

            /** @var Carbon $office_start_time */
            $office_start_time = $this->setting->getOfficeStartTime($row->date);
            $clock_out = $row->clock_out;

            $now = Carbon::now();

            /** @var Carbon $clock_in_time */
            $clock_in_time = $clock_in;

            if ($row->clock_out == null) {
                if ($now > $office_end_time) {
                    $clock_out_time = $office_end_time;
                } else {
                    $clock_out_time = Carbon::now();
                }
            } else {
                $clock_out_time = $clock_out;
            }

            $h = $clock_in_time->diffInHours($clock_out_time, false);
            $m = $clock_in_time->diffInMinutes($clock_out_time, false);

            $h = ($h < 0) ? 0 : $h;
            $m = ($m < 0) ? 0 : $m;

            $m = $m % 60;
            if ($h < 10) {
                $h = '0' . $h;
            }
            if ($m < 10) {
                $m = '0' . $m;
            }

            return $h . ":" . $m;
        })
            ->removeColumn('clock_in')
            ->rawColumns(['Hours','date','status','clock_out'])
            ->removeColumn('application_status')->make(true);
    }

    public function updateWorkFrom()
    {
        $date_obj = Carbon::now();
        $cur_date = $date_obj->format('Y-m-d');
        $fresh_attendance = Attendance::select('id', 'working_from')
            ->where('date', '=', $cur_date)
            ->where('employee_id', '=', employee()->id)
            ->first();
        if (empty($fresh_attendance)) {
            // Do not create new attendance if it does not exist
            //                $new_work               = new Attendance();
            //                $new_work->date         = $cur_date;
            //                $new_work->status       = 'present';
            //                $new_work->employee_id   = employee()->id;
            //                $new_work->working_from = Input::get('work_from');
            //                $new_work->save();

            return ['status' => 'success'];
        } else {
            $fresh_attendance->working_from = Input::get('work_from');
            $fresh_attendance->save();

            return ['status' => 'success'];
        }
    }

    public function updateNote()
    {
        $date_obj = Carbon::now();
        $cur_date = $date_obj->format('Y-m-d');
        $fresh_attendance = Attendance::select('id', 'notes')
            ->where('date', '=', $cur_date)
            ->where('employee_id', '=', employee()->id)
            ->first();
        if (empty($fresh_attendance)) {
            // Do not create new attendance if it does not exist
            //                $new_work             = new Attendance();
            //                $new_work->date       = $cur_date;
            //                $new_work->status     = 'present';
            //                $new_work->employee_id = employee()->id;
            //                $new_work->notes      = Input::get('notes');
            //                $new_work->save();

            return ['status' => 'success'];
        } else {
            $fresh_attendance->notes = Input::get('notes');
            $fresh_attendance->save();

            return ['status' => 'success'];
        }
    }

}
