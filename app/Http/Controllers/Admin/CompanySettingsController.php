<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Files;
use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;

use App\Http\Requests\Admin\Company\UpdateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;


class CompanySettingsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->csettingOpen = 'active';
        $this->pageTitle = 'Settings';
        $this->countries = Country::where('currency_symbol', '!=', 'null')->groupBy('currency_code')->get();
        $this->countrieslist = Country::all();
    }

    public function generalSetting()
    {
        $this->csettingActive = 'active';
        $this->countries = Country::where('currency_symbol', '!=', 'null')
            ->groupBy('currency_code')
            ->get();
        $this->company = admin()->company;
        return View::make('admin.company_settings.edit', $this->data);
    }

    public function generalSettingUpdate(UpdateRequest $request)
    {
        $data = $request->all();
        $company = admin()->company;


        $currencyArray = explode(':', $request->currency);
        $data['currency'] = $currencyArray[1];
        $data['currency_symbol'] = $currencyArray[0];
        $data['timezone'] = Input::get('timezone') . '=' . Input::get('timezoneIndex');

        unset($data["timezoneIndex"]);

        $company->update($data);

        if ($request->hasFile('logo')) {
            $file = new Files();
            $filename = $file->upload(Input::file('logo'), 'company_logo', null, 200, false);
            $company->logo = $filename;
            $company->save();
            return Reply::redirect(route('admin.general_setting.edit'));
        }

        return Reply::success('messages.updateSuccess');
    }

    public function edit($id)
    {
        $this->csettingActive = 'active';
        $this->countries = Country::where('currency_symbol', '!=', 'null')->groupBy('currency_code')
            ->get();

        return View::make('admin.company_settings.edit', $this->data);
    }

    public function theme()
    {
        $this->cthemeSettingActive = 'active';

        return View::make('admin.company_settings.theme', $this->data);
    }

    public function updateTheme(Request $request)
    {
        $company = admin()->company;
        $input = $request->all();
        $company->update($input);

        return Reply::success('messages.updateSuccess');
    }

    public function update(Request $request)
    {
        $company = admin()->company;

        $input = $request->all();

        if (Input::get('admin_theme') != '' || Input::get('front_theme') != '') {
            $company->update($input);

            return Reply::success('messages.updateSuccess');
        }

        if (admin()->type != 'superadmin') {
            return View::make('admin.errors.noaccess', $this->data);
        }

        $input['award_feature'] = (isset($input['award_feature'])) ? 1 : 0;
        $input['leave_feature'] = (isset($input['leave_feature'])) ? 1 : 0;
        $input['payroll_feature'] = (isset($input['payroll_feature'])) ? 1 : 0;
        $input['attendance_feature'] = (isset($input['attendance_feature'])) ? 1 : 0;
        $input['notice_feature'] = (isset($input['notice_feature'])) ? 1 : 0;
        $input['holidays_feature'] = (isset($input['holidays_feature'])) ? 1 : 0;
        $input['expense_feature'] = (isset($input['expense_feature'])) ? 1 : 0;
        $input['jobs_feature'] = (isset($input['jobs_feature'])) ? 1 : 0;

        $company->update($input);
        Session::flash('success', trans("messages.updateSuccess"));

        return Reply::success('messages.updateSuccess');

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

    public function features()
    {
        if (admin()->type != 'superadmin') {
            return View::make('admin.errors.noaccess', $this->data);
        }
        $this->csettingOpen = '';
        $this->settingOpen = 'active open';
        $this->cfeaturesActive = 'active';

        return View::make('admin.company_settings.features', $this->data);
    }

    public function notificationSetting()
    {
        $this->notificationSettingActive = 'active';

        return View::make('admin.notificationSettings.edit', $this->data);
    }

    public function updateNotification(Request $request)
    {

        $company = admin()->company;
        $input = $request->all();

        $input['award_notification'] = (isset($input['award_notification'])) ? 1 : 0;
        $input['leave_notification'] = (isset($input['leave_notification'])) ? 1 : 0;
        $input['payroll_notification'] = (isset($input['payroll_notification'])) ? 1 : 0;
        $input['attendance_notification'] = (isset($input['attendance_notification'])) ? 1 : 0;
        $input['notice_notification'] = (isset($input['notice_notification'])) ? 1 : 0;
        $input['expense_notification'] = (isset($input['expense_notification'])) ? 1 : 0;
        $input['employee_add'] = (isset($input['employee_add'])) ? 1 : 0;

        $company->update($input);

        return Reply::success('messages.updateSuccess');

    }

    public function updateAjaxNotification()
    {
        $setting = Company::findOrFail($this->company_id);
        $input[Input::get('type')] = Input::get('value');
        $setting->update($input);

        $output['success'] = 'success';

        return Response::json($output, 200);
    }

    public function attendance()
    {
        $company = admin()->company;
        if ($company->office_start_time != NULL && $company->office_end_time != NULL) {
            $this->officeStartTime = $company->getOfficeStartTime()->timezone($company->timezone)->format('g:i A');
            $this->officeEndTime = $company->getOfficeEndTime()->timezone($company->timezone)->format('g:i A');
        }
        return \View::make('admin.company_settings.attendance', $this->data);
    }

    public function attendanceUpdateSetting(Request $request)
    {
        $company = admin()->company;
        $company->mark_attendance = $request->mark_attendance;

        $start_time = Carbon::createFromFormat('g:i A', Input::get('start_time'), $company->timezone)->timezone('UTC');
        $end_time = Carbon::createFromFormat('g:i A', Input::get('end_time'), $company->timezone)->timezone('UTC');

        $company->office_start_time = $start_time;
        $company->office_end_time = $end_time;

        if (empty($request->late_mark)) {
            $company->late_mark_after = NULL;
        } else {
            $company->late_mark_after = $request->late_mark;
        }

        $company->attendance_setting_set = 1;
        $company->save();

        return Reply::success('messages.updateSuccess');
    }

}
