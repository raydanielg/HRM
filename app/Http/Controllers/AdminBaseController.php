<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BrowseHistory;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Language;
use App\Models\LeaveApplication;
use App\Models\Leavetype;
use App\Models\LicenseType;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Update;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use View;

class AdminBaseController extends \App\Http\Controllers\Controller
{

    /**
     * @var array
     */
    public $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }


    public function __construct()
    {

        $this->pageTitle = '';
        $this->setting = Setting::first();
        $locale = $this->setting->locale;
        $this->datatabble_lang = '';
        $this->data["displaySetup"] = false;

        $this->setting->currency = is_null($this->setting->currency) ? 'USD' : $this->setting->currency;
        $this->setting->currency_symbol = is_null($this->setting->currency_symbol) ? '$' : $this->setting->currency_symbol;

        $this->middleware(function ($request, $next) {
            if (admin()) {

                if (auth()->guard('admin')->viaRemember()) {
                    // If user logged in via remember me
                    $this->fireRememberMeLoginEvent();
                }

                $this->loggedAdmin = admin();


                #IF THE LOGGED IN USR IS A ADMIN
                if (admin()->type == 'admin') {
                    $this->browseHistory();
                    $company = Company::find(admin()->company_id);
                    $this->company =$company;

                } #IF THE LOGGED IN USER IS A SUPERADMIN

                elseif (admin()->type == 'superadmin') {
                    $company = $this->setting;
                    $this->companies = Company::orderBy('id', 'desc')->get();
                }

                $this->active_company = $company;

                if ($this->active_company) {
                    $locale = $company->locale;
                    App::setLocale($locale);
                    $this->data["unpaid_invoices"] = \App\Models\Invoice::where("company_id", $this->data["active_company"]->id)
                        ->where("status", "Unpaid")
                        ->count();


                    $this->company_id = $this->active_company->id;
                    Session::put('company_id', $this->company_id);
                    $this->folder = $this->company_id;
                    $this->str_len = strlen($this->company_id . '-') + 1;
                    $this->pending_applications = LeaveApplication::select('*', 'leave_applications.id as id')->where('application_status', '=', 'pending')
                        ->get();
                    $this->getSetupProgress();


                    if ($this->data["active_company"]->license_expired == 1) {
                        if (!Str::contains(request()->getRequestUri(), ["billing", "login", "check", "logout", "dashboard", "support", "password", "screenlock"])) {
                            //return View::make('admin.errors.error')->with('message',"Access to this page has been disabled because license of this account has been suspended. Please pay any undue bills if any to restore access.");
                            \App::abort(403, "Access to this page has been disabled because license of this account has been suspended. Please pay any undue bills if any to restore access.");
                        }
                    }
                }


                #IF THERE IS NOT A COMPANY IN DATABASE

                $this->languages = Language::all();


                $this->new_updates_count = Update::leftJoin("updates_read", function ($query) {
                    $query->on("updates_read.update_id", "=", "updates.id");
                    $query->on("admin_id", "=", \DB::raw(admin()->id));

                })
                    ->whereNull("admin_id")
                    ->where("updates.created_at", ">=", admin()->created_at)
                    ->where("status", "Published")
                    ->count();


            }
            return $next($request);
        });

        App::setLocale($locale);
        $this->locale = $locale;
        $freeUser = Plan::where('start_user_count', 0)->first();

        if($freeUser){
            $this->freeUsers = $freeUser->end_user_count;
        }else{
            $this->freeUsers =0;
        }

    }

    protected function fireRememberMeLoginEvent()
    {
        if (!\Session::has("login_session")) {
            \Session::set("login_session", true);
            $admin = admin();
            $admin->last_login = Carbon::now();
            $admin->number_of_logins = $admin->number_of_logins + 1;
            $admin->save();
        }
    }


    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }


    public function getSetupProgress()
    {

        $this->displaySetup = false;
        $totalSteps = 7;

        /** @var Company $company */
        $company = $this->data["active_company"];

        if ($company->logo == "default.png" && $company->address == "" && $company->billing_address == "" && $company->timezone == "+00:00=29") {
            $this->displaySetup = true;
            $this->totalSteps = $totalSteps;
            $this->nextStepNumber = 2;
            $this->nextStep = trans("core.setupStepCompanySettings");

            $this->nextStepLink = route("admin.general_setting.edit");

            return;
        }

        // Step 2
        $departmentCount = Department::company($this->company_id)->count();

        if ($departmentCount == 0) {

            $this->displaySetup = true;
            $this->totalSteps = $totalSteps;
            $this->nextStepNumber = 3;
            $this->nextStep = trans("core.setupStep1");

            $this->nextStepLink = route("admin.departments.index");

            return;
        }

        $employee_count = Employee::count();

        if ($employee_count == 0) {
            $this->displaySetup = true;

            $this->totalSteps = $totalSteps;
            $this->nextStepNumber = 4;
            $this->nextStep = trans("core.setupStep2");

            $this->nextStepLink = route("admin.employees.create");

            return;
        }

        $holidays_count = Holiday::count();

        if ($holidays_count == 0) {
            $this->displaySetup = true;

            $this->totalSteps = $totalSteps;
            $this->nextStepNumber = 5;
            $this->nextStep = trans("core.setupStep3");

            $this->nextStepLink = route("admin.holidays.index");

            return;
        }

        $leave_types_count = Leavetype::count();

        if ($leave_types_count == 0) {
            $this->displaySetup = true;

            $this->totalSteps = $totalSteps;
            $this->nextStepNumber = 6;
            $this->nextStep = trans("core.setupStep4");

            $this->nextStepLink = route("admin.leavetypes.index");

            return;
        }

        $attendance_count = Attendance::company($this->company_id)->count();

        if ($attendance_count == 0) {
            $this->displaySetup = true;

            $this->totalSteps = $totalSteps;
            $this->nextStepNumber = 7;
            $this->nextStep = trans("core.setupStep5");

            $this->nextStepLink = route("admin.attendances.create");

            return;
        }

    }

    public function clearSessionFlash()
    {
        \Session::remove("success");
    }

    public function browseHistory(){

        if ((admin()->type !== 'superadmin')) {
            // Save browse history
            $browse_history = new BrowseHistory();
            $browse_history->company_id = admin()->company_id;
            $browse_history->admin_id = admin()->id;
            $browse_history->ip = \Request::getClientIp();
            $browse_history->url = \Request::url();
            $browse_history->route = \Route::getCurrentRoute()->getName();
            $browse_history->save();
        }

    }

}
