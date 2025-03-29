<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\Award;
use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Expense;
use Illuminate\Support\Str;

class ExpenseObserver
{
    public function creating(Expense $model)
    {
        if (admin()) {
            $company = admin()->company;
            $model->company_id = admin()->company_id;
            if (!app()->runningInConsole()) {
                if ($company->expense_notification == 1) {
                    $employee = Employee::find($model->employee_id);

                    //---- EXPENSE EMAIL TEMPLATE-----

                    $emailInfo = [
                        'from_email' => $company->email,
                        'from_name' => $company->name,
                        'to' => $employee->email,
                        'active_company' => $company
                    ];
                    $fieldValues = [
                        'STATUS' => $model->status,
                        'DATE' => date('Y-m-d', strtotime($model->purchase_date))
                    ];
                    EmailTemplate::prepareAndSendEmail('EXPENSE_APPROVAL', $emailInfo, $fieldValues);
                    //---- EXPENSE  EMAIL TEMPLATE SENT-----
                }
            }


        }
        if (\employee()) {
            $company = \employee()->company;
            $model->company_id = employee()->company_id;
            $model->employee_id = employee()->id;

            $admins = Admin::where('company_id', $company->id)
                ->select('email')
                ->get();

            //--EXPENSE EMAIL CLAIM TEMPLATE
            foreach ($admins as $admin) {
                $emailInfo = [
                    'from_email' => $company->email,
                    'from_name' => $company->name,
                    'to' => $admin->email,
                    'active_company' => $company
                ];
                $fieldValues = [
                    'ITEM_NAME' => $model->item_name,
                    'NAME' => Str::words(employee()->full_name, 1, ''),
                    'PURCHASE_FROM' => $model->purchase_from,
                    'PURCHASE_DATE' => $model->purchase_date,
                    'PRICE' => $model->price
                ];

                EmailTemplate::prepareAndSendEmail('EXPENSE_CLAIM', $emailInfo, $fieldValues);
            }
        }

    }

}
