<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Files;
use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Setting\GdprUpdateRequest;
use App\Http\Requests\Admin\Setting\UpdateRequest;
use App\Http\Requests\Admin\SmtpSetting\UpdateSmtpSetting;
use App\Mail\TestEmailSent;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Setting;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Intervention\Image\File;


class SettingsController extends AdminBaseController
{


    public function __construct()
    {
        parent::__construct();
        $this->settingOpen = 'active';
        $this->pageTitle = 'Settings';
    }

    public function edit()
    {
        $this->settingActive = 'active';
        $this->generalSettingActive = 'active';
        $this->setting = Setting::all()->first();
        $this->countries = Country::where('currency_symbol', '!=', 'null')->groupBy('currency_code')
            ->get();

        return View::make('admin.settings.edit', $this->data);
    }


    public function getStripe()
    {
        $this->stripeSettingActive = 'active';
        $this->setting = Setting::all()->first();

        return View::make('admin.settings.stripe', $this->data);
    }

    public function getGdpr()
    {
        $this->stripeSettingActive = 'active';
        $this->setting = Setting::all()->first();

        return View::make('admin.settings.gdpr', $this->data);
    }

    public function getSmtp()
    {
        $this->smtpSettingActive = 'active';
        $this->setting = Setting::first();

        return View::make('admin.settings.smtp', $this->data);
    }

    public function change_language()
    {

        if (admin()->type == 'admin') {
            $setting = Company::findOrFail($this->company_id);
        } else {
            $setting = Setting::findOrFail($this->setting->id);
        }

        $data = Input::all();


        $setting->update($data);

        $output['success'] = 'success';

        return Response::json($output, 200);
    }

    public function update(UpdateRequest $request, $id)
    {
        $setting = Setting::first();
        $data = $request->all();

        unset($data['type']);

        if($request->has('currency')) {
            $currencyArray = explode(':', $request->currency);
            unset($data['currency']);

            $data['currency_symbol'] = $currencyArray[0];
            $data['currency'] = $currencyArray[1];
        }

        $setting->update($data);

        if ($request->hasFile('logo')) {
            $file = new Files();
            $filename = $file->upload(Input::file('logo'), 'setting/logo', null, 200, false);
            $setting->logo = $filename;
            $setting->save();
            return Reply::redirect(route('admin.settings.edit', 'settings'));
        }

        return Reply::success('messages.updateSuccess');
    }

    public function updateGDPR(GdprUpdateRequest $request)
    {
        $setting = Setting::first();
        $data = $request->all();

         if ($data['gdpr'] == $setting->gdpr) {
             if ($data['gdpr']) {
                 return Reply::error('GDPR status is already enabled');
             }

             return Reply::error('GDPR status is already disabled');
         }


        DB::beginTransaction();

        try {

            $setting->update($data);
            $columns = new Employee();
            $employees = Employee::withoutGlobalScope('company')->get();

            $columnsAdmins = new Admin();
            $admins = Admin::withoutGlobalScope('company')->get();

            // Encypted All the data

            foreach ($employees as $employee) {
                $employee->preventAttrSet = true;

                foreach ($columns->getEncrypted() as $item) {
                    if ($data['gdpr'] == 1) {
                        if(!is_null($employee->{$item})) {
                            $employee->{$item} = encrypt($employee->{$item});
                        }

                    } else {
                        if(!is_null($employee->{$item})) {
                            $employee->{$item} = decrypt($employee->{$item});
                        }
                    }

                }

                $employee->save();
            }

             foreach ($admins as $admin) {
                 $admin->preventAttrSet = true;

                 foreach ($columnsAdmins->getEncrypted() as $item) {

                     if ($data['gdpr'] == 1) {
                         if(!is_null($admin->{$item})) {
                             $admin->{$item} = encrypt($admin->{$item});
                         }
                     } else {
                         if(!is_null($admin->{$item})) {
                             $admin->{$item} = decrypt($admin->{$item});
                         }
                     }
                 }

                 $admin->save();
             }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
             return Reply::error('rollback'.$e->getMessage());
        }
        return Reply::success('messages.updateSuccess');
    }


    public function updateMailConfig(UpdateSmtpSetting $request)
    {
        $smtp = Setting::first();

        $data = $request->all();

        if ($request->mail_encryption == "null") {
            $data['mail_encryption'] = null;
        }

        unset($data['type']);
        $smtp->update($data);
        $response = $smtp->verifySmtp();
        session(['smtp_setting' => $smtp]);

        if ($smtp->mail_driver == 'mail') {
            return Reply::success(__('messages.updateSuccess'));
        }


        if ($response['success']) {
            return Reply::success($response['message']);
        }
        // GMAIL SMTP ERROR
        $message = __('messages.smtpError').'<br><br> ';

        if ($smtp->mail_host == 'smtp.gmail.com')
        {
            $secureUrl = 'https://myaccount.google.com/lesssecureapps';
            $message .= __('messages.smtpSecureEnabled');
            $message .= '<a  class="font-13" target="_blank" href="' . $secureUrl . '">' . $secureUrl . '</a>';
            $message .= '<hr>' . $response['message'];
            return Reply::error($message);
        }
        return Reply::error($message . '<hr>' . $response['message']);

    }

    public function sendTestEmail(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $smtp = Setting::first();
        $response = $smtp->verifySmtp();

        if ($response['success']) {
            Mail::to($request->test_email)->send(new TestEmailSent());
            return Reply::success('Test mail sent successfully');
        }
        return Reply::error($response['message']);
    }
}
