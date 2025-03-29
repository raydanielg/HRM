<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrowseHistory extends Model
{
    protected $table = "browse_history";

    public function scopeCompany($query, $id)
    {
        return $query->where('browse_history.company_id', '=', $id);
    }
}
