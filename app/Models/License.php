<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{

    protected $table = "licenses";
    protected $primaryKey = 'license_number';
    public static $rules = ['license_number' => 'required', 'name' => 'required', 'email' => 'required'];

    public static function licenseCount($type)
    {
        return License::join('license_types', 'license_types.id', '=', 'licenses.license_type_id')
            ->where('type', $type)->count();
    }
}
