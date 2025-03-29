<?php

namespace App\Observers;

use App\Models\Holiday;

class HolidayObserver
{

    public function saving(Holiday $holiday)
    {
        if (admin()) {
            $holiday->company_id = admin()->company_id;
        }

    }

}
