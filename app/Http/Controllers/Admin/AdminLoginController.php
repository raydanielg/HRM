<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Login\ForgotPasswordRequest;
use App\Http\Requests\Admin\Login\LoginRequest;
use App\Http\Requests\Admin\Login\ResetRequest;
use App\Models\Admin;
use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Str;

/*
 * Admin Login Controller
 */

class AdminLoginController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * When Admin is not logged in show the login page.
     * Otherwise redirect to Dashboard
     */
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard.index');
        }

        return \View::make('admin/login', $this->data);
    }


    /*
	 * When login button of admin is clicked .This Method checks the credentials from
	 * Database and return as success value.
	 */
    public function ajaxAdminLogin(LoginRequest $request)
    {

        $input = $request->all();

        $remember = false;

        $data = ['email' => $input['email'], 'password' => $input['password']];

        if (isset($input['remember'])) {
            $remember = true;
        }

        // Check if admin exists in database with the credentials or not

        if (auth()->guard('admin')->attempt($data, $remember)) {

            $admin = admin();

            $admin->last_login = Carbon::now();
            $admin->number_of_logins = $admin->number_of_logins + 1;
            $admin->save();

            $cookie = \Cookie::make('lock', '0'); // Reset the lock screen session;

            $reply = [];

            if ($admin->type == 'superadmin') {
                $url = (\Session::has('back_url_superadmin')) ? \Session::get('back_url_superadmin') : \URL::route('superadmin.dashboard.index');
                $reply = Reply::redirect($url, trans('messages.loginSuccess'));

            } else if ($admin->type == 'admin') {

                $company = Company::where('id', '=', $admin->company_id)->first();

                if ($company->status == 'inactive') {
                    auth()->guard('admin')->logout();
                    $reply = Reply::error(trans("messages.companyDisabled"));
                } else {

                    $url = (\Session::has('back_url_admin')) ? \Session::get('back_url_admin') : \URL::route('admin.dashboard.index');
                    $reply = Reply::redirect($url, trans('messages.loginSuccess'));

                }
            }
        } else {
            $message = (\Session::get("lock") != 1) ? trans('messages.loginInvalid') : trans('messages.wrongPassword');
            $reply = Reply::error($message);
        }

        $response = \Response::json($reply, 200);

        if (isset($cookie)) {
            $response->withCookie($cookie);
        }

        return $response;
    }

    public function forget_password(ForgotPasswordRequest $request)
    {


        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {

            $code = Str::random(60);
            $admin->reset_code = $code;
            $admin->save();

            $company = $admin->company ? $admin->company : Setting::first()->toArray();

            $emailInfo = [
                'from_email' => $company->email,
                'from_name' => $company->name,
                'to' => $request->email,
                'active_company' => $company
            ];

            $fieldValues = [
                'NAME' => $admin->name,
                'CODE_LINK' => \HTML::link('admin/password/reset/' . $code)
            ];

            EmailTemplate::prepareAndSendEmail('ADMIN_RESET_PASSWORD', $emailInfo, $fieldValues);

            return Reply::success(trans("messages.passwordReset"));


        }

        return Reply::error(trans("messages.emailNotFound"));

    }

    public function verify_email($code)
    {
        $admin = Admin::where('email_token', $code)->first();

        if ($admin) {
            $admin->email_token = null;
            $admin->email_verified = 'yes';
            $admin->save();
        } else {
            $this->wrong = 1;
        }

        return \View::make('admin.verify_email', $this->data);
    }


    public function get_reset($code)
    {
        $admin = Admin::where('reset_code', $code)->first();

        if ($admin == '') {
            $this->wrong = 1;
        }

        $this->reset_code = $code;

        return \View::make('admin.reset', $this->data);
    }

    public function post_reset(ResetRequest $request)
    {

        $admin = Admin::where('reset_code', $request->reset_code)->first();
        $admin->password = \Hash::make($request->password);
        $admin->reset_code = null;
        $admin->save();

        $company = $admin->company ? $admin->company : Setting::first()->toArray();

        $emailInfo = ['from_email' => $this->setting->email,
            'from_name' => $this->setting->name,
            'to' => $admin->email,
            'active_company' => $company
        ];

        $fieldValues = ['NAME' => $admin->name];

        EmailTemplate::prepareAndSendEmail('RESET_PASSWORD_SUCCESS', $emailInfo, $fieldValues);

        return Reply::success(trans("messages.passwordResetSuccess"));
    }

    /*
	 * When logout button of admin panel is clicked. This method is called.This method destroys all the
	 * the session stored and redirect to the Login Page
	 */
    public function logout()
    {
        auth()->guard('admin')->logout();

        return redirect()->route('login');
    }
}
