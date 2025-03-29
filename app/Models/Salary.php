<?php

namespace App\Models;
class Salary extends \Eloquent
{


    protected $fillable = [];
    protected $table = 'salary';
    protected $guarded = ['id'];

    public function scopeCompany($query, $id)
    {
        return $query->join('employees', 'salary.employeeID', '=', 'employees.employeeID')
            ->where('employees.company_id', '=', $id);
    }
}
