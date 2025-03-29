<?php

namespace App\Observers;

use App\Models\LeaveApplication;

class LeaveApplicationObserver
{
    public function creating(LeaveApplication $model)
    {
        if(employee()) {
            $model->employee_id = employee()->id;
            $model->company_id = employee()->company_id;
        }

        $model->application_status = 'pending';
        $model->applied_on = date('Y-m-d', time());

        /*if (employee()) {
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
                        'from_email' => $company->email,
                        'from_name' => $company->name,
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
        }*/
    }
}
