<?php

namespace App\Observers;

use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Payroll;

class EmployeeObserver
{
    public function creating(Employee $employee)
    {
        if (admin()) {
            $company = admin()->company;
            $employee->company_id = admin()->company_id;
            if (!app()->runningInConsole()) {
                if ($company->employee_add == 1) {

                    $emailInfo = [
                        'from_email' => $company->email,
                        'from_name' => $company->name,
                        'to' => $employee->email,
                        'active_company' => $company
                    ];

                    $fieldValues = [
                        'NAME' => $employee->full_name,
                        'EMAIL' => $employee->email,
                        'PASSWORD' => request()->password,
                        'COMPANY_NAME' => $company->company_name
                    ];

                    EmailTemplate::prepareAndSendEmail('EMPLOYEE_ADD', $emailInfo, $fieldValues);
                    //---- PREPARE AND SEND EMAIL-----

                }
            }
        }
    }
}
