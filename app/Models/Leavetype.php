<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Leavetype extends \Eloquent
{

    // Don't forget to fill this array
    protected $fillable = ['leaveType', 'num_of_leave'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('leavetypes.company_id', '=', admin()->company_id);
            }

            if (employee()) {
                $builder->where('leavetypes.company_id', '=', employee()->company_id);
            }
        });
    }

}
