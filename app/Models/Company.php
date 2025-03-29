<?php

namespace App\Models;


use App\Observers\CompanyObserver;
use Carbon\Carbon;
use Laravel\Cashier\Billable;


class Company extends \Eloquent
{

    use Billable;

    protected $fillable = ['company_name','contact','address','name','email','country','timezone','logo','locale','billing_address','currency','currency_symbol'];

    protected $dates = ['deleted_at', 'last_login', 'trial_ends_at', 'subscription_ends_at', 'licence_expire_on'];

    protected $appends = ['logo_image_url'];


    public function users()
    {
        return $this->hasMany('App\Models\Admin', 'company_id', 'id');
    }

    public function subscriptionPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'subscription_plan_id');
    }

    public function getLangName()
    {
        // belongs('OtherClass','thisclasskey','otherclasskey')
        return $this->belongsTo('App\Models\Language', 'locale', 'locale');
    }

    public function lastLoginAdmin()
    {
        return Admin::where('company_id', $this->id)->orderBy('last_login', 'desc')->first();
    }

    public function getTimezoneAttribute($value)
    {
        return explode("=", $value)[0];
    }

    public function getTimezoneIndexAttribute()
    {
        return explode("=", $this->attributes["timezone"])[1];
    }

    public function getOfficeEndTime(Carbon $date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }

        $dateStr = $date->format("Y-m-d");

        $end = Carbon::createFromFormat("Y-m-d H:i:s", $dateStr . " " . $this->attributes["office_end_time"]);
        $start = Carbon::createFromFormat("Y-m-d H:i:s", $dateStr . " " . $this->attributes["office_start_time"]);

        if ($end < $start) {
            $end->addDay();
        }

        return $end;
    }

    public function getOfficeStartTime(Carbon $date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }

        $dateStr = $date->format("Y-m-d");

        $start = Carbon::createFromFormat("Y-m-d H:i:s", $dateStr . " " . $this->attributes["office_start_time"]);

        return $start;
    }

    public static function dateOf11Employee($company_id)
    {
        $el = Employee::where('company_id', $company_id)->skip(10)->take(1)->first();
        return isset($el->created_at) ? $el->created_at : '-';

    }

    public function getLogoImageUrlAttribute($size = 150, $d = 'mm')
    {
        if (is_null($this->logo) || $this->logo == 'default.png') {

            $settings = Setting::first();

            if(is_null($settings->logo) || $settings->logo == 'default.png' ) {
                return $url = asset('assets/admin/layout/img/hrm-logo-full.png');
            }
            return $url = asset_url('setting/logo/' . $settings->logo);
        }

        if (strpos($this->logo, 'https://') !== false) {
            return $image = str_replace('type=normal', 'type=large', $this->logo);
        }

        return asset_url('company_logo/' . $this->logo);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

}
