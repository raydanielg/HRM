<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class Department extends \Eloquent
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('department.company_id', admin()->company_id);
            }
            if (employee()) {
                $builder->where('department.company_id', employee()->company_id);
            }
        });
    }


    protected $table = "department";

    // Don't forget to fill this array
    protected $fillable = ['name'];

    protected $guarded = ['id'];

    protected function designations()
    {
        return $this->hasMany('App\Models\Designation', 'department_id', 'id');
    }

    protected function DepartmentManager()
    {
        return $this->hasMany('App\Models\DepartmentManager', 'department_id', 'id');
    }

    public function checkDepartment($manager_id)
    {
        $dept = DepartmentManager::select('department_id')->where('manager_id', $manager_id)->where('department_id', $this->id)->get();
        if (count($dept) > 0) return true;
        else
            return false;
    }

    public function scopeCompany($query, $id)
    {
        return $query->where('department.company_id', '=', $id);
    }

    public function scopeManager($query, $id)
    {
        if (admin()->manager == 1) {
            return $query->join('department_manager', 'department_manager.department_id', '=', 'department.id')
                ->where('department_manager.manager_id', '=', $id);
        }
        return null;

    }
}
