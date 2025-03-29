<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Payroll extends \Eloquent
{
    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('payrolls.company_id', admin()->company_id);
            }

            if (employee()) {
                $builder->where('payrolls.company_id', employee()->company_id);
            }
        });


    }


    // Don't forget to fill this array
    protected $fillable = [];
    protected $guarded = ['id'];

    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }


    public function scopeCompanywithdept($query, $id)
    {
        return $query->join('employees', 'payrolls.employee_id', '=', 'employees.id')
            ->join('designation', 'designation.id', '=', 'employees.designation')
            ->join('department', 'designation.department_id', '=', 'department.id')
            ->where('department.company_id', '=', $id);
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
}
