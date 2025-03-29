<?php

namespace App\Observers;

use App\Models\Holiday;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingsObserver
{

    public function updating(Setting $setting)
    {
        if($setting->isDirty('stripe_key')) {
            DB::table('subscriptions')->truncate();;
        }
    }

}
