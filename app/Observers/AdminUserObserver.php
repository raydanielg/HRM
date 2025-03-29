<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\EmailTemplate;

class AdminUserObserver
{
    public function creating(Admin $model)
    {
        if (admin() && \admin()->type == 'admin') {
            $company = admin()->company;
            $model->company_id = admin()->company_id;

            if (!app()->runningInConsole()) {
                if ($company->admin_add == 1) {
                    $emailInfo = [
                        'from_email' => $company->email,
                        'from_name' => $company->name,
                        'to' => $model->email,
                        'active_company' => $company
                    ];

                    $fieldValues = [
                        'NAME' => $model->name,
                        'EMAIL' => $model->email,
                        'PASSWORD' => $model->password,
                        'COMPANY_NAME' => $company->company_name

                    ];

                    EmailTemplate::prepareAndSendEmail('NEW_ADMIN', $emailInfo, $fieldValues);

                    //---- NEW ADMIN ADD EMAIL CLOSE-----
                }
            }

        }
    }
}
