<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class FrontBaseController extends BaseController
{

    public function __construct()
    {
        parent::__construct();


        $this->appSetting = Setting::first();



        $this->middleware(function ($request, $next) {

            if (employee()) {
                $this->employeeID = employee()->id;
                $this->employee = employee();

                $this->setting = employee()->company;

                App::setLocale($this->setting->locale);

                $this->company_id = employee()->company->id;
                Session::put('company_id', $this->company_id);

                $this->active_company = employee()->company;


                $this->folder = $this->company_id;

                $this->datatabble_lang = '';

                if (file_exists("assets/global/plugins/datatables/langjson/{$this->setting->locale}.json")) {
                    $url = URL::asset("assets/global/plugins/datatables/langjson/{$this->setting->locale}.json");
                    $this->datatabble_lang = "'language': {
                    'url': '$url'
                },";
                }


                $this->company_name = employee()->company->company_name;


                $this->leaveTypes = Attendance::leaveTypesEmployees($this->company_id);



                $this->leaveLeft = $this->employee->leaveLeft();


                $this->attendance_count = Attendance::attendanceCount(\employee()->id, $this->company_id);


                $this->current_month_birthdays = Employee::currentMonthBirthday($this->company_id);

            }

            return $next($request);
        });
    }


    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }


}

