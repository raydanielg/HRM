<!DOCTYPE html>

<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Verify Email - HRM</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <!-- BEGIN  STYLES -->
    {!! HTML::style("https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all", array("name" => "core"))!!}
    {!! HTML::style("assets/global/plugins/font-awesome/css/font-awesome.min.css") !!}
    {!! HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css") !!}
    {!! HTML::style("assets/admin/pages/css/login-soft.css") !!}
    {!! HTML::style("assets/global/css/components.css") !!}
    {!! HTML::style("assets/admin/layout/css/layout.css?v=1") !!}
            <!-- END STYLES -->


</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="javascript:;">
        <img src="{{$setting->logo_image_url}}" height="50px">
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content" style="width:100%">
    @if(isset($wrong)==1)
        <h3 class="text-center"><i class="fa fa-frown-o"></i> Your reset token has expired</h3>
    @else
        <h3 class="text-center"><i class="fa fa-smile-o"></i> Congratulations! Your email is now verified.</h3>
    @endif
    <p class="text-center">Click <a style="color:#FFBABA" href="{{route('login')}}">here</a> to go to Login Page</p>
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    {{ date('Y') }} &copy; {{ $setting->main_name }}
</div>
<!--[if lt IE 9]>
{!! HTML::script('assets/global/plugins/respond.min.js')!!}
{!! HTML::script('assets/global/plugins/excanvas.min.js')!!}
<![endif]-->
{!! HTML::script("assets/global/plugins/jquery.min.js")!!}
{!! HTML::script("assets/global/plugins/bootstrap/js/bootstrap.min.js") !!}
{!! HTML::script("assets/global/plugins/backstretch/jquery.backstretch.min.js") !!}

        <!-- END PAGE LEVEL SCRIPTS -->

<script>
    jQuery(document).ready(function () {
        // init background slide images
        $.backstretch([
                    "{{URL::asset('front_assets/img/bg/1.jpg')}}"
                ], {
                    fade: 1000,
                    duration: 8000
                }
        );
    });
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
