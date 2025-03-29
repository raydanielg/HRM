<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Job extends \Eloquent
{

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('jobs.company_id', admin()->company_id);
            }
            if (employee()) {
                $builder->where('jobs.company_id', employee()->company_id);
            }
        });


    }


    // Add your validation rules here
    public static $rules = ['position' => 'required', 'description' => 'required|min:20'];

    // Don't forget to fill this array
    protected $fillable = ['position', 'description', 'posted_date', 'last_date', 'close_date', 'status',
        'company_id'];

    public function setPostedDateAttribute($value)
    {
        $this->attributes['posted_date'] = date('Y-m-d', strtotime($value));
    }

    public function setLastDateAttribute($value)
    {
        $this->attributes['last_date'] = date('Y-m-d', strtotime($value));
    }

    public function setCloseDateAttribute($value)
    {
        $this->attributes['close_date'] = date('Y-m-d', strtotime($value));
    }

    public function scopeCompany($query, $id)
    {
        return $query->where('jobs.company_id', '=', $id);
    }
}
