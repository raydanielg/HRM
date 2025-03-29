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
</head>

<body>

<!--=== Content Part ===-->
<div class="container">

    <!--Reg Block-->

    <div class="reg-block">


        <div class="reg-block-header">

            <h2><img src="{{ asset('/assets/admin/layout/img/hrm-logo-full-white.png') }}" height="40px" alt=""></h2>


        </div>
        <div class="tab-v2">
            <div class="form-actions rem">
                <a href="{{route('LaravelInstaller::welcome')}}" class="btn btn-sm btn-block btn-rounded btn-primary text-uppercase">Visit installer</a>
            </div>
        </div>
        <!-- END FORGOT PASSWORD FORM -->
    </div>
</div><!--/container-->
<!-- JS Customization -->

</body>
</html>
