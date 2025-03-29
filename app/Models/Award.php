<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Award extends \Eloquent
{

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('awards.company_id', admin()->company_id);
            }
            if (employee()) {
                $builder->where('awards.company_id', employee()->company_id);
            }
        });


    }

    public function employee()
    {

        return $this->belongsTo(Employee::class);
    }

    public function scopeCompany($query, $id)
    {
        return $query->join('employees', 'awards.employeeID', '=', 'employees.employeeID')
            ->where('employees.company_id', '=', $id);
    }

//        public function scopeManager($query, $id)
//        {
//            if(admin()->manager==1){
//                return $query->join('designation', 'designation.id', '=', 'employees.designation')
//                             ->join('department', 'designation.department_id', '=', 'department.id')
//                            ->join('department_manager', 'department_manager.department_id', '=', 'department.id')
//                             ->where('department_manager.manager_id', '=', $id);
//            }
//            return $query->join('designation', 'designation.id', '=', 'employees.designation')
//                         ->join('department', 'designation.department_id', '=', 'department.id');
//
//        }


}
