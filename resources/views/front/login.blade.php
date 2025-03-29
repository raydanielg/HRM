<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title> HRM - Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    {!! HTML::style("https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all", array("name" => "core"))!!}
    {!! HTML::style('front_assets/plugins/bootstrap/css/bootstrap.min.css') !!}
    {!! HTML::style('front_assets/css/style.css?v=1') !!}
    {!! HTML::style('front_assets/plugins/line-icons/line-icons.css') !!}
    {!! HTML::style('front_assets/plugins/font-awesome/css/font-awesome.min.css') !!}
    {!! HTML::style('assets/global/plugins/uniform/css/uniform.default.min.css')!!}
    {!! HTML::style('assets/global/plugins/froiden-helper/helper.css') !!}
    {!! HTML::style('front_assets/css/pages/page_log_reg_v2.css') !!}
    {!! HTML::style('front_assets/css/custom.css') !!}
    {!! HTML::style('assets/global/plugins/bootstrap-toastr/toastr.min.css') !!}
</head>

<body>
{{-----------------MAINTENANCE CHECK----------------}}
@include('maintenance_check')
{{----------------MAINTENANCE CHECK----------------}}
<!--=== Content Part ===-->
<div class="container">

    <!--Reg Block-->

    <div class="reg-block">


        <div class="reg-block-header">

            <h2><img src="{{$appSetting->logo_image_url}}" height="50px"></h2>


        </div>
        <div class="tab-v2">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#employee" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i>
                        Employee</a></li>
                <li class=""><a href="#manager" data-toggle="tab" aria-expanded="false"><i class="fa fa-lock"></i>
                        Manager</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="employee">
                    {!!  Form::open(array('id'=>'login-form', 'class'=>'login-form'))  !!}
                    <div class="form-group rem margin-bottom-20">
                        <div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email"
                                       placeholder="{{ trans('core.email') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group rem margin-bottom-20">
                        <div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password"
                                       placeholder="{{ trans('core.password') }}"
                                       required>
                            </div>
                        </div>
                    </div>

                    <label style="font-weight: normal;" class="margin-bottom-20 rem">
                        <input type="checkbox" name="remember"> Always stay signed in
                    </label>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <button type="submit" class="btn-u btn-block input-group" id="submitbutton"
                                    onclick="login(); return false;">{{trans('core.btnLogin')}}</button>
                        </div>
                    </div>

                    <hr>
                    <div class="forget-password">
                        <h4>Forgot your password?</h4>

                        <p>
                            no worries, click <a href="javascript:;" id="forget-password">
                                here </a>
                            to reset your password.
                        </p>
                    </div>

                    {!!  Form::close()!!}

                <!-- BEGIN FORGOT PASSWORD FORM -->
                    {!! Form::open(['url' => '', 'method' => 'post','class'=>'forget-form', 'style' => "display: none"]) !!}
                    <h3>Forgot Password?</h3>

                    <p>
                        Enter your e-mail address below to reset your password.
                    </p>

                    <div id="alert_forget">

                    </div>
                    <div class="form-group">
                        <div>
                            <div class="input-group ">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email"
                                       placeholder="{{trans('core.email')}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions rem">
                        <button type="button" id="back-btn" class="btn">
                            <i class="m-icon-swapleft"></i> Back
                        </button>
                        <button type="submit" class="btn-u blue pull-right" id="submitbutton_forget"
                                onclick="forgetPassword();return false;">
                            Submit <i class="m-icon-swapright m-icon-white"></i>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>


                <div class="tab-pane fade" id="manager">
                    {!! Form::open(array('url' => '', 'class' => 'login-form-admin')) !!}
                    <div class="form-group rem margin-bottom-20">
                        <div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email"
                                       placeholder="{{ trans('core.email') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group rem margin-bottom-20">
                        <div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password"
                                       placeholder="{{ trans('core.password') }}"
                                       required>
                            </div>
                        </div>
                    </div>

                    <label style="font-weight: normal;" class="margin-bottom-20">
                        <input type="checkbox" name="remember"> Always stay signed in
                    </label>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <button type="submit" class="btn-u btn-block input-group" id="submitbuttonAdmin"
                                    onclick="loginAdmin(); return false;">@lang('core.btnLogin')</button>
                        </div>
                    </div>
                    <hr>
                    <div class="forget-password">
                        <h4>Forgot your password?</h4>
                        <p>
                            no worries, click <a style="color:#F44336" href="javascript:;" id="forget-password-admin">
                                here </a>
                            to reset your password.
                        </p>
                    </div>

                    {!! Form::close() !!}
                <!-- END ADMIN LOGIN FORM -->

                    <!-- BEGIN ADMIN FORGOT PASSWORD FORM -->
                    {!! Form::open(['url' => '', 'method' => 'post','class'=>'forget-form-admin', 'style' => "display: none"]) !!}
                    <h3>Forgot Password?</h3>

                    <p>
                        Enter your e-mail address below to reset your password.
                    </p>
                    <div class="form-group">
                        <div>
                            <div class="input-group margin-bottom-20">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email"
                                       placeholder="{{trans('core.email')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="back-btn-admin" class="btn">
                            <i class="m-icon-swapleft"></i> Back
                        </button>
                        <button type="button" class="btn-u blue pull-right" id="submitbutton_forget_admin"
                                onclick="forgetPasswordAdmin(); return false;">
                            Submit <i class="m-icon-swapright m-icon-white"></i>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="form-actions rem">
                    <a href="/" class="btn btn-sm btn-block btn-rounded btn-primary text-uppercase">Go to Frontend Site</a>
                </div>
            </div>
        </div>
        <!-- END FORGOT PASSWORD FORM -->
    </div>
</div><!--/container-->
{!! HTML::script('front_assets/plugins/jquery/jquery.min.js')!!}
{!! HTML::script('front_assets/plugins/jquery/jquery-migrate.min.js')!!}
{!! HTML::script('front_assets/plugins/bootstrap/js/bootstrap.min.js')!!}
{!! HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')!!}
{!! HTML::script('front_assets/plugins/back-to-top.js')!!}
{!! HTML::script('front_assets/plugins/backstretch/jquery.backstretch.min.js')!!}
{!! HTML::script('assets/global/plugins/jquery.blockui.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-toastr/toastr.min.js') !!}
{!! HTML::script('assets/global/plugins/froiden-helper/helper.js')!!}
{!! HTML::script("assets/admin/layout/scripts/app.js")!!}

<!--[if lt IE 9]>
{!!  HTML::script('front_assets/plugins/respond.js') !!}
{!!  HTML::script('front_assets/plugins/html5shiv.js')   !!}
{!!  HTML::script('front_assets/js/plugins/placeholder-IE-fixes.js')!!}


<![endif]-->
<!-- JS Customization -->

<script>
    function login() {
        $.easyAjax({
            url: "{!! route('login_check') !!}",
            type: "POST",
            data: $(".login-form").serialize(),
            container: ".login-form",
            messagePosition: "inline"
        });
    }

    function forgetPassword() {
        $.easyAjax({
            url: "{!! route('front.forget_password') !!}",
            type: "POST",
            data: $(".forget-form").serialize(),
            container: ".forget-form",
            messagePosition: "inline",
            removeElements: true
        });
    }

    jQuery('#forget-password').click(function () {
        jQuery('.login-form').hide();
        jQuery('.forget-form').show();
    });

    jQuery('#back-btn').click(function () {
        jQuery('.login-form').show();
        jQuery('.forget-form').hide();

    });


    function loginAdmin() {
        $.easyAjax({
            url: "{!! route('admin.login') !!}",
            type: "POST",
            data: $(".login-form-admin").serialize(),
            container: ".login-form-admin",
            messagePosition: "inline"
        });
    }

    function forgetPasswordAdmin() {
        $.easyAjax({
            url: "{!! route('admin.forget_password') !!}",
            type: "POST",
            data: $(".forget-form-admin").serialize(),
            container: ".forget-form-admin",
            messagePosition: "inline",
            removeElements: true
        });
    }


    jQuery('#forget-password-admin').click(function () {
        jQuery('.login-form-admin').hide();
        jQuery('.forget-form-admin').show();
    });

    jQuery('#back-btn-admin').click(function () {
        jQuery('.login-form-admin').show();
        jQuery('.forget-form-admin').hide();

    });

</script>
</body>
</html> 
