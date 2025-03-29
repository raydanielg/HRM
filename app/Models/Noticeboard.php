<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Noticeboard
 * @package App\Models
 */
class Noticeboard extends \Eloquent
{

    // Don't forget to fill this array
    protected $fillable = ['title', 'description', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if(admin()) {
                $builder->where('noticeboards.company_id', '=', admin()->company_id);
            }
            if (employee()) {
                $builder->where('noticeboards.company_id', '=', employee()->company_id);
            }
        });
    }
}
