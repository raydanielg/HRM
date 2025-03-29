<?php

namespace App\Observers;

use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Leavetype;
use App\Models\Noticeboard;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;

class LeaveTypeObserver
{

    public function saving(Leavetype $leavetype)
    {
        if (admin()) {
            $leavetype->company_id = admin()->company_id;
        }
    }

}
