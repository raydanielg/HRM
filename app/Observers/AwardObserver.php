<?php

namespace App\Observers;

use App\Models\Award;
use App\Models\EmailTemplate;
use App\Models\Employee;

class AwardObserver
{
    public function creating(Award $model)
    {
        if (admin()) {
            $company = admin()->company;
            $model->company_id = admin()->company_id;
            if (!\App::runningInConsole()) {
                if ($company->award_notification == 1) {
                    $employee = Employee::find($model->employee_id);

                    //---- AWARD EMAIL TEMPLATE-----
                    $emailInfo = [
                        'from_email' => $company->email,
                        'from_name' => $company->name,
                        'to' => $employee->email,
                        'active_company' => $company
                    ];

                    $fieldValues = ['NAME' => $employee->full_name, 'AWARD' => $model->award_name];

                    EmailTemplate::prepareAndSendEmail('AWARD', $emailInfo, $fieldValues);
                    //---- AWARD EMAIL TEMPLATE SENT-----

                }
            }

        }
    }
}
