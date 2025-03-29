<!DOCTYPE html>

<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]--><!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]--><!--[if !IE]><!-->
<html lang="en" class="no-js">

@include('admin.include.head')
<body class="page-header-fixed page-quick-sidebar-over-content page-style-square @if(\Cookie::get("sidebar_closed") == "1") page-sidebar-closed @endif">
@if(isset($company) && is_null($company->subscription_plan_id) && $loggedAdmin->type !=='superadmin')
    @include('admin.include.plan-null-header')
@else
    @include('admin.include.header')
@endif

<div class="clearfix"></div>

<!-- BEGIN CONTAINER -->
<div class="page-container">

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

            @yield('mainarea')

        </div>

    </div>
    <!-- END CONTENT -->

</div>
<!-- END CONTAINER -->

@include('admin.include.footer')

@include('admin.include.footerjs')
@include('admin.common.error')

</body>
<!-- END BODY -->
</html>
