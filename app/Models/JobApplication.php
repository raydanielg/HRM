<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class JobApplication extends \Eloquent
{

    protected $appends = ['resume_url'];

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('job_applications.company_id', admin()->company_id);
            }
            if (employee()) {
                $builder->where('job_applications.company_id', employee()->company_id);
            }
        });


    }


    // Don't forget to fill this array
    protected $fillable = ['job_id', 'name', 'phone', 'email', 'resume', 'cover_letter', 'submitted_by'];

    protected function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id', 'id');
    }

    public function employee()
    {

        return $this->belongsTo(Employee::class, 'submitted_by', 'id');
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

    public function getResumeUrlAttribute()
    {
        return asset_url('job_applications/' . $this->resume);

    }
}
