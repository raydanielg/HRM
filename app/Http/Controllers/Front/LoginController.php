<?php

namespace App\Http\Controllers\Front;

use App\Classes\Reply;
use App\Http\Controllers\FrontBaseController;
use App\Http\Requests\Front\Login\ForgotPasswordRequest;
use App\Http\Requests\Front\Login\LoginRequest;
use App\Http\Requests\Front\Login\ResetPasswordRequest;
use App\Models\EmailTemplate;
use App\Models\Employee;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Support\Str;

class LoginController extends FrontBaseController
{
    use AppBoot;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Login Page';
    }

    public function index()
    {
        if (!$this->isLegal()) {
            return redirect('verify-purchase');
        }

        if (auth()->guard('employee')->check()) {
            return redirect()->route('dashboard.index');
        }

        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard.index');
        }
        return \View::make('front.login', $this->data);

    }

    public function ajaxLogin(LoginRequest $request)
    {

        $data = [
            'email' => $request['email'],
            'password' => $request['password'],
            'status' => 'active'
        ];

        $remember = false;

        if ($request->remember == 'on') {
            $remember = true;
        }

        $employee = Employee::where('email', $request->email)->first();

        if ($employee) {
            // Check user status
            if ($employee->status == 'inactive') {
                return Reply::error("messages.loginBlocked");
            }

            // Check company status
            if ($employee->company->status == 'inactive') {
                return Reply::error("messages.companyDisabled");
            }

            if (auth()->guard('employee')->attempt($data, $remember)) {

                $this->company_id = $employee->company_id;

                return Reply::redirect(route('dashboard.index'), 'messages.loginSuccess');
            }
        }

        return Reply::error("messages.loginInvalid");
    }

    public function forget_password(ForgotPasswordRequest $request)
    {

        // Check if employee exists in database with the credentials of not

        $employee = Employee::where('email', $request->email)->first();

        $company = $employee->company;

        if ($employee) {

            $code = Str::random(60);
            $employee->reset_code = $code;
            $employee->save();

            //---- RESET EMAIL SENDING-----

            $emailInfo = [
                'from_email' => $company->email,
                'from_name' => $company->name,
                'to' => $request->email,
                'active_company' => $company
            ];

            $fieldValues = [
                'NAME' => $employee->name,
                'CODE_LINK' => \HTML::link('password/reset/' . $code)
            ];

            EmailTemplate::prepareAndSendEmail('FRONT_RESET_PASSWORD', $emailInfo, $fieldValues);

            //---- RESET EMAIL SENDING CLOSE-----

            return Reply::success("messages.passwordReset");

        } // Show error Message if employee with posted data doesn't exists

        return Reply::error("messages.emailNotFound");
    }

    public function get_reset($code)
    {
        $employee = Employee::where('reset_code', $code)->first();

        if ($employee == '') {
            $this->wrong = 1;
        }

        $this->reset_code = $code;

        return \View::make('front.reset', $this->data);
    }

    public function post_reset(ResetPasswordRequest $request)
    {

        $employee = Employee::where('reset_code', $request->reset_code)->first();
        $employee->password = $request->password;
        $employee->reset_code = null;
        $employee->save();

        $company = $employee->company;
        //---- RESET SUCCESS EMAIL SENDING-----

        $emailInfo = [
            'from_email' => $company->email,
            'from_name' => $company->name,
            'to' => $employee->email,
            'active_company' => $company];

        $fieldValues = ['NAME' => $employee->name];

        EmailTemplate::prepareAndSendEmail('RESET_PASSWORD_SUCCESS', $emailInfo, $fieldValues);

        //---- RESET SUCCESS EMAIL SENDING CLOSE-----

        return Reply::success("messages.passwordResetSuccess");
    }

    public function logout()
    {
        auth()->guard('employee')->logout();
        return \Redirect::to(route('login'));
    }

}
