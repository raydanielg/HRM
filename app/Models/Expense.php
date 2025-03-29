<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Builder;

class Expense extends \Eloquent
{

    use Sluggable, SluggableScopeHelpers;

    protected $fillable = ['item_name', 'purchase_from', 'purchase_date', 'price', 'employee_id', 'status'];
    protected $appends = ['bill_url'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'item_name'
            ]
        ];
    }

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('expenses.company_id', admin()->company_id);
            }

            if (employee()) {
                $builder->where('expenses.company_id', employee()->company_id);
            }
        });

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

    public function setPurchaseDateAttribute($value)
    {
        $this->attributes['purchase_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getBillUrlAttribute()
    {
        return asset_url('expense/bills/' . $this->bill);
    }
}
