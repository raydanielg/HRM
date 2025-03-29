<?php

namespace App\Observers;

use App\Models\EmailTemplate;
use App\Models\Employee;
use App\Models\Noticeboard;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;

class NoticeboardObserver
{
    /**
     * Handle the noticeboard "created" event.
     *
     * @param  \App\Models\Noticeboard $noticeboard
     * @return void
     */
    public function created(Noticeboard $noticeboard)
    {
        if (!\App::runningInConsole()) {

            if (admin()) {
                $company = admin()->company;
                $noticeboard->company_id = admin()->company_id;

                if ($company->notice_notification == 1) {
                    //        Send email to all employees
                    $employees = Employee::select('email', 'full_name')
                        ->where('status', '=', 'active')
                        ->get();

                    //---- EXPENSE EMAIL TEMPLATE-----

                    $link = \HTML::link(URL::to('dashboard'), 'Here');

                    foreach ($employees as $employee) {
                        $email = "{$employee->email}";

                        $emailInfo = [
                            'from_email' => $company->email,
                            'from_name' => $company->name,
                            'to' => $email,
                            'active_company' => $company
                        ];
                        $fieldValues = ['LINK' => $link, 'NAME' => $employee->full_name];

                        EmailTemplate::prepareAndSendEmail('NEW_NOTICE', $emailInfo, $fieldValues);
                    }
                }
            }

        }

    }

    public function saving(Noticeboard $noticeboard)
    {
        if (admin()) {
            $noticeboard->company_id = admin()->company_id;
        }

    }

}
