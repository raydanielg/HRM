<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\Award;
use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\JobApplication;
use Illuminate\Support\Str;

class JobApplicationObserver
{
    public function creating(JobApplication $model)
    {

        if (\employee()) {
            $company = \employee()->company;
            $model->company_id = employee()->company_id;
            $model->submitted_by = employee()->id;

            $admins = Admin::where('company_id', $company->id)
                ->select('email')
                ->get();


            $link = "<a href='https://docs.google.com/viewer?url={$model->resume_url}' target='_blank'>view Resume</a>";

            foreach ($admins as $admin) {
                $emailInfo = [
                    'from_email' => $company->email,
                    'from_name' => $company->name,
                    'to' => $admin->email,
                    'active_company' => $company
                ];
                $fieldValues = [
                    'EMPLOYEE_NAME' => Str::words(\employee()->full_name, 1, ''),
                    'NAME' => $model->name,
                    'EMAIL' => $model->email,
                    'PHONE' => $model->phone,
                    'POSITION' => $model->job->position,
                    'COVER_LETTER' => $model->cover_letter,
                    'LINK' => $link
                ];

                EmailTemplate::prepareAndSendEmail('JOB_APPLICATION_REQUEST', $emailInfo, $fieldValues);

            }


        }

    }

}
