<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>{{ $appSetting->main_name}} | Login Page</title>
    <!-- Meta -->
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
<!--=== Content Part ===-->
<div class="container">
    <!--Reg Block-->

    <div class="reg-block">
        <div class="reg-block-header">
            <h2><img src="{{$appSetting->logo_image_url}}" height="50px"></h2>
        </div>
        @if(isset($wrong)==1)
            <h3 class="text-center"> Reset Token is expired</h3>
            <p class="text-center">Click <a href="{{route('login')}}">here</a> to go to Login Page</p>
        @else
            {!! Form::open(array('url' => '','class' =>'login-form'))  !!}

            <h3>Reset Password</h3>
            <p>
                Enter new password to reset your password.
            </p>
            <div id="alert">

            </div>
            <div class="form-group rem">
                <div>
                    <div class="input-group ">

                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="hidden" name="reset_code" value="{{ $reset_code }}"/>
                        <input class="form-control" type="password" autocomplete="off"
                               placeholder="{{trans('core.password')}}" name="password">
                    </div>
                </div>
            </div>
            <div class="form-group rem">
                <div>
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input class="form-control" type="password" autocomplete="off"
                               placeholder="{{trans('core.confirmPassword')}}" name="password_confirmation">
                    </div>
                </div>
            </div>
            <hr>


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <button class="btn-u btn-block input-group" id="submitbutton"
                            onclick="PasswordReset();return false;">
                        Reset <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>
            </div>


            {!! Form::close() !!}

            <div class="row" id="successMsg" style="display: none">
                <div class="col-md-10 col-md-offset-1">
                    <a class="btn btn-sm btn-block btn-rounded btn-primary text-uppercase" href="{{route('login')}}">
                        Back to Login <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
    <!--End Reg Block-->


</div><!--/container-->
<!--=== End Content Part ===-->
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
    function PasswordReset() {
        $.easyAjax({
            url: "{!! route('front.password.post_reset') !!}",
            type: "POST",
            data: $(".login-form").serialize(),
            container: ".login-form",
            messagePosition: "inline",
            removeElements: true,
            success: function (response) {
                if (response.status === "success") {
                    $('#successMsg').show();
                }
            }
        });
    }

</script>
</body>
</html>
