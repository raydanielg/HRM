<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Attendance extends \Eloquent
{

    protected $table = 'attendance';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
//                $builder->join('employees', 'attendance.employee_id', '=', 'employees.employeeID');
//                $builder->where('employees.company_id', '=', admin()->company_id);
            }
            if (employee()) {
//                $builder->join('employees', 'attendance.employee_id', '=', 'employees.employeeID')
//                    ->where('employees.company_id', '=', employee()->company_id);
            }
        });


    }

    //    Get employee Details
    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }

    //    Total number of Day the employee  present
    public static function countPresentDays($month, $year, $employeeID)
    {
        $fullday = count(DB::select(DB::raw("select * from attendance where YEAR(date)=" . $year . "
	                                            AND MONTH(date)=" . $month . " AND attendance.status='present'
	                                            AND employee_id='$employeeID'")));

        $halfday = count(DB::select(DB::raw("select * from attendance where YEAR(date)=" . $year . "
			                                    AND MONTH(date)=" . $month . " AND attendance.status='absent' AND halfDayType='yes'
			                                    AND (application_status IS NULL OR application_status='approved')
			                                    AND employee_id='$employeeID'")));

        return ($fullday + $halfday / 2);
    }


    public static function leaveTypesEmployees($company_id, $method = 'all')
    {
        $leaveTypes = [];
        foreach (Leavetype::get() as $leave) {
            $leaveTypes[$leave->leaveType] = $leave->leaveType;

        }
        return $leaveTypes;
    }


    //    Function for counting the current month present
    public static function attendanceCount($employeeID, $company_id)
    {
        // Calculating Attendance
        $date = date('d');
        $month = date('m');
        $year = date('Y');
        $firstDay = $year . '-' . $month . '-' . $date;

        $presentCount = Attendance::countPresentDays($month, $year, $employeeID);

        $totalDays = date('t', strtotime($firstDay));

        $holiday_count = count(DB::select(DB::raw("SELECT * FROM holidays WHERE MONTH(date)=" . $month . " AND YEAR(date)=" . $year . " and company_id =" . $company_id)));
        $workingDays = $totalDays - $holiday_count;

        return "{$presentCount}/$workingDays";
    }

    //Function to count the total leaves taken
    public static function absentEmployee($employeeID)
    {

        $absent = [];
        foreach (Leavetype::get() as $leave) {
            $half_day = Attendance::where('attendance.status', '=', 'absent')->where(function ($query) {
                $query->where('application_status', '=', 'approved')
                    ->orWhere('application_status', '=', null);
            })->where('employee_id', '=', $employeeID)//FOr unpaid Leaves
            ->where('halfDayType', '=', 'yes')
                ->where('leaveType', '=', $leave->leaveType)->count();

            // Added to casual
            $half = $half_day / 2;
            $absent[$leave->leaveType] = Attendance::where('attendance.status', '=', 'absent')->where(function ($query) {
                $query->where('application_status', '=', 'approved')
                    ->orWhere('application_status', '=', null);
            })->where('employee_id', '=', $employeeID)//For Unpaid Leaves
            ->where('leaveType', '=', $leave->leaveType)
                ->where('halfDayType', '<>', 'yes')
                ->count();
            $absent[$leave->leaveType] += $half;

        }

        return $absent;
    }


    public static function absentEveryEmployee()
    {
        $employees = Employee::where('status', '=', 'active')->get();
        $absentess = [];
        $year = date('Y');
        foreach ($employees as $employee) {

            //Count the absent except half days
            foreach (Leavetype::get() as $leave) {
                //      Half Day leaves are added to casual leaves.2 half days are equal to one Casual Leave

                $absentess[$employee->employeeID][$leave->leaveType] = Attendance::where('attendance.status', '=', 'absent')
                    ->where('employee_id', '=', $employee->id)
                    ->where(function ($query) {
                        $query->where('application_status', '=', 'approved')
                            ->orWhere('application_status', '=', null);
                    })
                    ->where('leaveType', '=', $leave->leaveType)
                    ->where('halfDayType', '<>', 'yes')
                    ->where(DB::raw('YEAR(date)'), '=', $year)
                    ->count();

                $half_day = Attendance::where('status', '=', 'absent')
                    ->where('employee_id', '=', $employee->id)
                    ->where(function ($query) {
                        $query->where('application_status', '=', 'approved')
                            ->orWhere('application_status', '=', null);
                    })
                    ->where('leaveType', '=', $leave->leaveType)
                    ->where('halfDayType', '=', 'yes')
                    ->where(DB::raw('YEAR(date)'), '=', $year)
                    ->count();

                $absentess[$employee->id][$leave->leaveType] += $half_day / 2;
            }

            //  Total of All leaves
            $absentess[$employee->id]['total'] = isset($absentess[$employee->id]) ? array_sum($absentess[$employee->id]) : 0;
        }

        return $absentess;
    }

    public function scopeCompany($query, $id)
    {
        return $query->join('employees', 'attendance.employee_id', '=', 'employees.id')
            ->where('employees.company_id', '=', $id);
    }


    public function scopeManager($query, $id)
    {
        if (admin()->manager == 1) {
            return $query->join('designation', 'designation.id', '=', 'employees.designation')
                ->join('department', 'designation.department_id', '=', 'department.id')
                ->join('department_manager', 'department_manager.department_id', '=', 'department.id')
                ->where('department_manager.manager_id', '=', $id);
        }
        return $query->join('designation', 'designation.id', '=', 'employees.designation')
            ->join('department', 'designation.department_id', '=', 'department.id');

    }

    public function getClockInAttribute($value)
    {
        if ($value == null) {
            return $value;
        }

        $carbon = Carbon::createFromFormat("Y-m-d H:i:s", $this->attributes["date"] . " " . $value);

        // This case occurs if attendance is of prev day and user clocked in today
        if ($carbon->diffInHours() > 24) {
            $carbon->subDay();
        }
        return $carbon;
    }

    public function getClockOutAttribute($value)
    {
        if ($value == null) {
            return $value;
        }

        $carbon = Carbon::createFromFormat("Y-m-d H:i:s", $this->attributes["date"] . " " . $value);

        // This occurs if attendance is of prev day and user clocked in today
        if ($carbon < $this->clock_in) {
            $carbon->addDay();
        }

        return $carbon;
    }

    public function getDateAttribute($value)
    {
        if ($value == null) {
            return $value;
        }

        $carbon = Carbon::createFromFormat("Y-m-d 00:00:00", $this->attributes["date"] . " 00:00:00");

        return $carbon;
    }


}
