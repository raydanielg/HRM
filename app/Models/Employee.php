<?php

namespace App\Models;

use Carbon\Carbon;
use Dialect\Gdpr\EncryptsAttributes;
use Dialect\Gdpr\Portable;
use Illuminate\Auth\UserTrait;

use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Support\Facades\Hash;

class Employee extends \Eloquent implements Authenticatable, CanResetPasswordContract
{
    use  Portable, AuthenticableTrait, CanResetPassword;

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {

            if (admin()) {
                $builder->where('employees.company_id', admin()->company_id);
            }
        });
    }


    protected $fillable = [
        'employeeID',
        'designation',
        'full_name',
        'father_name',
        'gender',
        'email',
        'password',
        'date_of_birth',
        'mobile_number',
        'local_address',
        'profile_image',
        'joining_date',
        'permanent_address'
    ];

    protected $hidden = ['password'];

    protected $appends = ['profile_image_url', 'work_duration'];
    protected $dates = [
        'created_at',
        'updated_at',
        'last_login',
        'joining_date',
        'exit_date',
        'date_of_birth',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function getDesignation()
    {
        return $this->belongsTo('App\Models\Designation', 'designation', 'id');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Employee_document');
    }

    public function salaries()
    {
        return $this->hasMany('App\Models\Salary');
    }

    public function awards()
    {
        return $this->hasMany('App\Models\Award');
    }

    public function bank_details()
    {
        return $this->hasOne('App\Models\Bank_detail');
    }

    // get attendances
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }


    public static function currentMonthBirthday($company_id)
    {
        $birthdays = Employee::where('company_id', $company_id)->select('full_name', 'date_of_birth', 'profile_image')
            ->whereRaw("MONTH(date_of_birth) = ?", [date('m')])->where('status', '=', 'active')
            ->orderBy('date_of_birth', 'asc')->get();

        return $birthdays;
    }

    public function getWorkDurationAttribute()
    {
        /** @var Carbon $joiningDate */
        $joiningDate = $this->joining_date;

        /** @var Carbon $exitDate */
        $exitDate = $this->exit_date;

        if ($exitDate == null) {
            $exitDate = Carbon::now();
        }

        if ($joiningDate == null) {
            return '-';
        }

        $diff = $exitDate->diff($joiningDate);

        $string = ($d = $diff->d) ? ' ' . $d . ' d' : '';
        $string = ($m = $diff->m) ? ($string ? ' ' : ' ') . $m . ' m' . $string : $string;
        $string = ($y = $diff->y) ? $y . ' y' . $string : $string;

        $string = ($diff->d == 0 && $diff->m == 0 && $diff->y == 0) ? 'Joined Today' : $string;

        return $string;
    }

    /**
     * Get the last absent days
     * If the user is not absent since joining then.Joining date is last absent date
     */
    public function lastAbsent($type = 'days')
    {
        $absent = Attendance::where('status', '=', 'absent')->where('employee_id', '=', $this->id)
            ->where(function ($query) {
                $query->where('application_status', '=', 'approved')
                    ->orWhere('application_status', '=', null);
            })->orderBy('date', 'desc')->first();

        $lastDate = date('Y-m-d');
        $old_date = isset($absent->date) ? $absent->date : $this->joining_date;
        $diff = date_diff(date_create($old_date), date_create($lastDate));

        if ($diff->d == 0 || !isset($absent->date)) {
            return '<span class="label label-danger">' . trans("core.never") . '</span>';
        }

        $difference = $diff->format('%a') . ' days ago';
        if ($type == 'days') {
            return $difference;
        } elseif ($type == 'date') {
            return date_create($old_date)->format('d-M-Y');
        }
    }

    public function leaveLeft()
    {

        $total_leave = Leavetype::get()
                ->sum('num_of_leave') + $this->annual_leave;

        $leaveLeft = array_sum(Attendance::absentEmployee(employee()->id)) . '/' . $total_leave;

        return $leaveLeft;
    }


    public function scopeManager($query)
    {
        if (admin()->manager == 1) {
            return $query->join('designation', 'designation.id', '=', 'employees.designation')
                ->join('department', 'designation.department_id', '=', 'department.id')
                ->join('department_manager', 'department_manager.department_id', '=', 'department.id')
                ->join('admins', 'admins.id', '=', 'department_manager.manager_id')
                ->where('department_manager.manager_id', '=', admin()->id);
        }
        return $query->join('designation', 'designation.id', '=', 'employees.designation')
            ->join('department', 'designation.department_id', '=', 'department.id');

    }

    public function getProfileImageUrlAttribute()
    {

        $size = 250;
        $d = 'mm';

        if ($this->profile_image === 'default.jpg' || $this->profile_image == '' || $this->profile_image == null) {
            return $url = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=' . $d . '&s=' . $size;
        }

        if (strpos($this->profile_image, 'https://') !== false) {
            return $image = str_replace('type=normal', 'type=large', $this->profile_image);
        }

        return asset_url('profile_images/' . $this->profile_image);

    }


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = date('Y-m-d', strtotime($value));
    }

    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = date('Y-m-d', strtotime($value));
    }


    public $preventAttrSet = false;

    public function toPortableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

    public function getEncrypted()
    {
        return $this->encrypted;
    }

    public function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);

        if (in_array($key, $this->encrypted) &&
            !is_null($value)) {
            $gdpr = Setting::first()->gdpr;

            if (!$this->preventAttrSet && $gdpr === 1) {
                $value = decrypt($value);
            }
        }

        return $value;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return $this
     */
    public function setAttribute(
        $key,
        $value
    )
    {
        if (in_array($key, $this->encrypted) &&
            !is_null($value)) {
            $gdpr = Setting::first()->gdpr;

            if (!$this->preventAttrSet && $gdpr === 1) {
                $value = encrypt($value);
            }
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Return Model in array type, with all datas decrypted.
     * @return array
     */
    public function decryptToArray()
    {
        $model = [];
        foreach ($this->attributes as $attributeKey => $attributeValue) {
            $model[$attributeKey] = $this->$attributeKey;
        }

        return $model;
    }

    /**
     * Return Model in collection type, with all datas decrypted.
     * @return array
     */
    public function decryptToCollection()
    {
        $model = collect();
        foreach ($this->attributes as $attributeKey => $attributeValue) {
            $model->$attributeKey = $this->$attributeKey;
        }

        return $model;
    }

    protected $encrypted = [
        'full_name',
        'mobile_number',
        'father_name',
        'local_address',
        'permanent_address'
    ];
}
