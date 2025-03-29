<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class LicenseType extends Model
    {
        use \Venturecraft\Revisionable\RevisionableTrait;

        protected $revisionEnabled = true;
        protected $revisionCreationsEnabled = true;
        protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
        protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old

        protected $table = "license_types";

        protected $fillable = ["name", "description", "free_users", "per_user_monthly_price", "per_user_yearly_price",
                               "one_time_fees", "type", "status"];

        public static function getPlanName($id)
        {
            return LicenseType::find($id)->name;
        }


    }
