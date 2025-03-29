<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\Job;

class JobObserver
{
    public function creating(Job $model)
    {
        if (admin() && \admin()->type == 'admin') {
            $model->company_id = admin()->company_id;
        }
    }
}
