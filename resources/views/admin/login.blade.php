<!-- Login Page -->
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>Login Page</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    {!! HTML::style("https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all", array("name" => "core"))!!}
    {!! HTML::style("assets/global/plugins/font-awesome/css/font-awesome.min.css") !!}
    {!! HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css") !!}
    {!! HTML::style('assets/global/plugins/uniform/css/uniform.default.min.css')!!}
    {!! HTML::style('assets/global/plugins/froiden-helper/helper.css') !!}
    {!! HTML::style("assets/admin/pages/css/login-soft.css") !!}
    {!! HTML::style("assets/global/css/components.css") !!}
    {!! HTML::style("assets/admin/layout/css/layout.css?v=1") !!}
    {!! HTML::style("assets/admin/layout/css/themes/light.css") !!}
    {!! HTML::style('assets/global/plugins/bootstrap-toastr/toastr.min.css') !!}
</head>
<body class="login">
{{------------------MAINTENANCE CHECK------------------}}
@include('maintenance_check')
{{------------------MAINTENANCE CHECK------------------}}

<div class="logo">
    <a href="javacript:;">
        <img src="{{$setting->logo_image_url}}" height="50px">
    </a>
</div>
<div class="content">

    <!-- Login Form -->
    {!! Form::open(array('url' => '', 'class' =>'login-form')) !!}

    <h3 class="form-title">@lang('messages.loginPageMessage')</h3>

    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">{{ trans('core.email') }}</label>

        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input class="form-control placeholder-no-fix" type="email" autocomplete="off"
                   placeholder="{{ trans('core.email')}}" name="email"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">{{ trans('core.password') }}</label>

        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="{{ trans('core.password') }}" name="password"/>
        </div>
    </div>
    <div class="form-actions">
        <label class="">
            <input type="checkbox" name="remember" value="1"/> Remember me </label>

        <button type="submit" class="btn blue pull-right" id="submitbutton" onclick="login(); return false;">
            {{ trans('core.btnLogin') }} <i class="m-icon-swapright m-icon-white"></i>
        </button>
    </div>
    <div class="forget-password">
        <h4>Forgot your password?</h4>

        <p>
            no worries, click <a style="color:#F44336" href="javascript:;" id="forget-password">
                here </a>
            to reset your password.
        </p>
    </div>

    {!! Form::close() !!}
<!-- END LOGIN FORM -->


    <!-- BEGIN FORGOT PASSWORD FORM -->
    {!! Form::open(['url' => '', 'method' => 'post', 'class'=>'forget-form']) !!}
    <h3>Forgot Password?</h3>

    <p>
        Enter your e-mail address below to reset your password.
    </p>

    <div id="alert_forget">

    </div>
    <div class="form-group rem">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" id="email"
                   name="email"/>
        </div>
    </div>
    <div class="form-actions rem">
        <button type="button" id="back-btn" class="btn">
            <i class="m-icon-swapleft"></i> Back
        </button>
        <button type="button" class="btn blue pull-right" id="submitbutton_forget"
                onclick="forgetPassword(); return false;">
            Submit <i class="m-icon-swapright m-icon-white"></i>
        </button>
    </div>
{!! Form::close() !!}
<!-- END FORGOT PASSWORD FORM -->

</div>
<div class="copyright">
    {{ \Carbon\Carbon::now()->format("Y") }} &copy; {{ $setting->company_name }}
</div>
<!--[if lt IE 9]>
{!! HTML::script('assets/global/plugins/respond.min.js')!!}
{!! HTML::script('assets/global/plugins/excanvas.min.js')!!}
<![endif]-->
{!! HTML::script("assets/global/plugins/jquery.min.js")!!}
{!! HTML::script("assets/global/plugins/bootstrap/js/bootstrap.min.js") !!}
{!! HTML::script("assets/global/plugins/backstretch/jquery.backstretch.min.js") !!}
{!! HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')!!}
{!! HTML::script('assets/global/plugins/jquery.blockui.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-toastr/toastr.min.js') !!}
{!! HTML::script('assets/global/plugins/froiden-helper/helper.js')!!}
{!! HTML::script("assets/admin/layout/scripts/app.js")!!}

<script>
    jQuery(document).ready(function () {

        // init background slide images
        $.backstretch([
                "{!! URL::asset('assets/admin/pages/media/bg/1.jpg') !!}"
            ], {
                fade: 1000,
                duration: 8000
            }
        );
    });
</script>


<script>
    function login() {
        $.easyAjax({
            url: "{!! route('admin.login') !!}",
            type: "POST",
            data: $(".login-form").serialize(),
            container: ".login-form",
            messagePosition: "inline"
        });
    }

    function forgetPassword() {
        $.easyAjax({
            url: "{!! route('admin.forget_password') !!}",
            type: "POST",
            data: $(".forget-form").serialize(),
            container: ".forget-form",
            messagePosition: "inline"
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


</script>
</body>
</html>
