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
    <title>Forget Password</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <!-- BEGIN  STYLES -->
    {!! HTML::style("https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all", array("name" => "core"))!!}
    {!! HTML::style('front_assets/plugins/bootstrap/css/bootstrap.min.css') !!}
    {!! HTML::style('front_assets/css/style.css?v=1') !!}
    {!! HTML::style('front_assets/plugins/line-icons/line-icons.css') !!}
    {!! HTML::style('front_assets/plugins/font-awesome/css/font-awesome.min.css') !!}
    {!! HTML::style('front_assets/css/pages/page_log_reg_v2.css') !!}
    {!! HTML::style("front_assets/css/theme-colors/default.css") !!}
    {!! HTML::style('assets/global/plugins/froiden-helper/helper.css') !!}
    {!! HTML::style('front_assets/css/custom.css') !!}
    {!! HTML::style('assets/global/plugins/bootstrap-toastr/toastr.min.css') !!}
</head>
<body class="login">
<div class="container">
    <div class="reg-block">
        <div class="reg-block-header">
            <h2>  <img src="{{$setting->logo_image_url}}" height="50px"></h2>
        </div>
        @if(isset($wrong) == 1)
            <h3 class="text-center"> Reset token has expired</h3>
            <p class="text-center">Click <a href="{{route('login')}}">here</a> to go to Login Page</p>
        @else
            {!! Form::open(array('url' => '','class' => 'login-form'))  !!}

            <h3>Reset Password</h3>
            <p>
                Enter new password to reset your password.
            </p>
            <div id="alert"></div>
            <div class="form-group rem margin-bottom-20">
                <div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="hidden" name="reset_code" value="{{ $reset_code }}"/>
                        <input class="form-control" type="password" autocomplete="off"
                               placeholder="{{trans('core.password')}}" name="password" required>
                    </div>
                </div>
            </div>
            <div class="form-group rem margin-bottom-20">
                <div><!-- Extra div for helper plugin -->
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                        <input class="form-control" type="password" autocomplete="off"
                               placeholder="{{trans('core.confirmPassword')}}" name="password_confirmation" required>
                    </div>
                </div>
            </div>
            <hr>


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <button type="button" class="btn-u btn-block input-group" id="submitbutton"
                            onclick="PasswordReset();return false;">
                        Reset <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>
            </div>


            {!! Form::close() !!}
        @endif
    </div>
    <!--End Reg Block-->


</div><!--/container-->
{!! HTML::script('front_assets/plugins/jquery/jquery.min.js')!!}
{!! HTML::script('front_assets/plugins/jquery/jquery-migrate.min.js')!!}
{!! HTML::script('front_assets/plugins/bootstrap/js/bootstrap.min.js')!!}
        <!-- JS Implementing Plugins -->
{!! HTML::script('front_assets/plugins/back-to-top.js')!!}
{!! HTML::script('front_assets/plugins/backstretch/jquery.backstretch.min.js')!!}
{!! HTML::script('assets/global/plugins/jquery.blockui.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-toastr/toastr.min.js') !!}
{!! HTML::script('assets/global/plugins/froiden-helper/helper.js')!!}

<script type="text/javascript">
    $.backstretch([
        "{{URL::asset('front_assets/img/bg/1.jpg')}}"
    ], {
        fade: 1000,
        duration: 7000
    });
</script>

<!--[if lt IE 9] -->
{!!  HTML::script('front_assets/plugins/respond.js') !!}
{!!  HTML::script('front_assets/plugins/html5shiv.js')   !!}
{!!  HTML::script('front_assets/js/plugins/placeholder-IE-fixes.js')!!}


<script>
    function PasswordReset() {
        $.easyAjax({
            url: "{{ route('admin.password.post_reset') }}",
            type: "POST",
            data: $(".login-form").serialize(),
            container: ".login-form",
            messagePosition: "inline",
            removeElements: true
        });
    }
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
