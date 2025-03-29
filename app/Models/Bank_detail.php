<?php

namespace App\Models;

/**
 * Class Bank_detail
 * @package App\Models
 */
class Bank_detail extends \Eloquent
{
    protected $fillable = ['employee_id', 'account_name', 'account_number', 'bank', 'pan', 'ifsc', 'branch'];
    protected $guarded = [''];

    /**
     * @return mixed
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
