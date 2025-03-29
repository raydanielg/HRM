<?php

namespace App\Observers;

use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Setting;

class PayrollObserver
{
    public function creating(Payroll $model)
    {
        if (admin()) {
            $settings = Setting::first();
            $company = admin()->company;
            $model->company_id = admin()->company_id;

            if (!\App::runningInConsole()) {

                if ($company->payroll_notification == 1) {
                    $employee = Employee::select('email', 'full_name')
                        ->where('id', '=', $model->employee_id)->first();

                    $dt = \DateTime::createFromFormat('!m', $model->month);
                    $month = $dt->format('F');
                    $year = $model->year;


                    //---- PAYSLIP EMAIL TEMPLATE-----
                    $emailInfo = [
                        'from_email' => $settings->email,
                        'from_name' => $settings->name,
                        'to' => $employee->email,
                        'active_company' => $company
                    ];
                    $fieldValues = [
                        'MONTH_YEAR' => $month . '-' . $year,
                        'NAME' => $employee->full_name
                    ];

                    EmailTemplate::prepareAndSendEmail('NEW_PAYSLIP', $emailInfo, $fieldValues);

                }
            }
        }
    }
}
