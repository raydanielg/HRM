<?php

namespace App\Providers;

use App\Http\Middleware\EncryptCookies;
use App\Models\Admin;
use App\Models\Award;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Holiday;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\LeaveApplication;
use App\Models\Leavetype;
use App\Models\Noticeboard;
use App\Models\Payroll;
use App\Models\Setting;
use App\Observers\AdminUserObserver;
use App\Observers\AwardObserver;
use App\Observers\CompanyObserver;
use App\Observers\DepartmentObserver;
use App\Observers\EmployeeObserver;
use App\Observers\ExpenseObserver;
use App\Observers\HolidayObserver;
use App\Observers\JobApplicationObserver;
use App\Observers\JobObserver;
use App\Observers\LeaveApplicationObserver;
use App\Observers\LeaveTypeObserver;
use App\Observers\NoticeboardObserver;
use App\Observers\PayrollObserver;
use App\Observers\SettingsObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // translation directive
        Blade::directive('trans', function ($key) {
            return '<?php echo preg_replace("/^.*\./", "", app(\'translator\')->getFromJson(' . $key . ')); ?>';
        });

        \Validator::extend('company', function($attribute, $value, $parameters, $validator) {
            $emp  = Employee::join('designation', 'designation.id', '=', 'employees.designation')
                ->join('department', 'designation.department_id', '=', 'department.id')->where('employeeID','=',$value)
                ->where('department.company_id', '=', $parameters[0])->first();
            if(sizeof($emp)){
                return true;
            } else {
                return false;
            }
        });

        Schema::defaultStringLength(191); //NEW: Increase StringLength
        Award::observe(AwardObserver::class);
        Expense::observe(ExpenseObserver::class);
        Noticeboard::observe(NoticeboardObserver::class);
        Leavetype::observe(LeaveTypeObserver::class);
        Holiday::observe(HolidayObserver::class);
        Admin::observe(AdminUserObserver::class);
        Job::observe(JobObserver::class);
        Payroll::observe(PayrollObserver::class);
        Employee::observe(EmployeeObserver::class);
        Department::observe(DepartmentObserver::class);
        Company::observe(CompanyObserver::class);
        JobApplication::observe(JobApplicationObserver::class);
        LeaveApplication::observe(LeaveApplicationObserver::class);
        Setting::observe(SettingsObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Illuminate\Cookie\Middleware\EncryptCookies');
        $this->app->resolving(EncryptCookies::class, function ($object) {
            $object->disableFor('sidebar_closed');
        });
    }
}
