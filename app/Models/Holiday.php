<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Holiday extends \Eloquent
{

    // Add your validation rules here
    public static $rules = ['date.0' => 'required_with:occasion.0',];

    // Don't forget to fill this array
    protected $fillable = [];

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('company', function (Builder $builder) {
            if (admin()) {
                $builder->where('holidays.company_id', admin()->company_id);
            }
            if (employee()) {
                $builder->where('holidays.company_id', employee()->company_id);
            }
        });


    }


}
