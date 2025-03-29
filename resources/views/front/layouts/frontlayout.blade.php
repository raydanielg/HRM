<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <title>{{$setting->company_name}} - {{$pageTitle}} </title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- CSS Global Compulsory -->
{!! HTML::style('front_assets/plugins/bootstrap/css/bootstrap.min.css') !!}
{!! HTML::style('front_assets/css/style.css?v=2')!!}
<!-- CSS Implementing Plugins -->

{!! HTML::style('front_assets/plugins/font-awesome/css/font-awesome.min.css') !!}
{!! HTML::style('front_assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css') !!}

{!! HTML::style('front_assets/plugins/scrollbar/src/perfect-scrollbar.css') !!}
{!! HTML::style('front_assets/plugins/fullcalendar/fullcalendar.css') !!}
{!! HTML::style('front_assets/plugins/fullcalendar/fullcalendar.print.css',array('media' => 'print')) !!}


<!-- CSS Page Style -->
{!! HTML::style('front_assets/css/pages/profile.css') !!}



<!-- CSS Theme -->
{!! HTML::style("front_assets/css/theme-colors/$setting->front_theme.css") !!}
{!! HTML::style('assets/global/plugins/uniform/css/uniform.default.min.css')!!}
<!-- CSS Customization -->


    {!! HTML::style('front_assets/css/custom.css') !!}
    {!! HTML::style('assets/global/plugins/froiden-helper/helper.css') !!}
    @yield('head')

</head>

<body>
<div class="wrapper">
    <!--=== Header ===-->
    <div class="header">
        <!-- Navbar -->
        <div class="navbar navbar-default mega-menu" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('dashboard.index')}}">
                        {!! HTML::image($setting->logo_image_url,'Logo',array('class'=>'logo-default','id'=>'logo-header','height'=>'30px'))!!}

                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav">
                    @if ($active_company->license_expired != 1)

                        <!-- Home -->
                            <li class="{{isset($homeActive) ? $homeActive : ''}}">
                                <a href="{{ route('dashboard.index')}}">
                                    {{__('menu.home')}}
                                </a>
                            </li>
                            <!-- End Home -->
                        @if($setting->leave_feature==1)
                            <!-- Leave -->
                                <li class="dropdown {{isset($leaveActive) ? $leaveActive : ''}}">
                                    <a href="" href="javascript:void(0);" class="dropdown-toggle"
                                       data-toggle="dropdown">
                                        {{__('menu.leave')}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" onclick="leaveModal();return false;"> {{__('menu.applyLeave')}}</a></li>
                                        <li><a href="{{route('leaves.index')}}"> {{__('menu.myLeave')}}</a></li>

                                    </ul>
                                </li>
                        @endif
                        <!-- Leave -->
                            <li class="dropdown @if(isset($salaryActive)) {{ $salaryActive}} @elseif (Route::is("front.expenses.index")) open @endif">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                    Self
                                </a>
                                <ul class="dropdown-menu">
                                    @if($setting->payroll_feature==1)
                                        <li><a href="{{ route('front.salary')}}"> {{__('menu.salarySlip')}}</a>
                                        </li>
                                    @endif
                                    @if($setting->expense_feature==1)
                                        <li>
                                            <a href="{{route('front.expenses.index')}}"> {{trans('menu.expenseFront')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <!-- End Leave -->
                            <!-- End Home -->
                            <!-- Job -->
                            @if($setting->jobs_feature==1)
                                <li class="{{isset($jobActive) ? $jobActive : ''}}">
                                    <a href="{{ route('jobs.index')}}">
                                        {{__('menu.job')}}
                                    </a>
                                </li>
                            @endif
                        <!-- Job -->
                            @if($setting->mark_attendance==1 && $setting->attendance_setting_set == 1)
                                {{--Attendance--}}

                                <li class="{{isset($attendanceActive) ? $attendanceActive : ''}}">
                                    <a href="{{ route('front.attendance.index')}}">
                                        {{__('core.attendance')}}
                                    </a>
                                </li>
                        @endif

                        {{--End Attendance--}}
                    @endif
                    <!-- My Account -->
                        <li class="dropdown {{isset($accountActive) ? $accountActive : ''}}">
                            <a href="" href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                {{__('menu.myAccount')}}
                            </a>

                            <ul class="dropdown-menu">

                                @if ($active_company->license_expired != 1)
                                    <li><a href="" data-toggle="modal" data-target=".change_password_modal"
                                           id="change_password_link"> {{__('menu.changePassword')}}</a></li>
                                @endif
                            <!-- Logout -->
                                @if(auth()->guard('employee')->check())
                                    <li>
                                        <a href="{{route('front.logout')}}">
                                            {{__('menu.logout')}}
                                        </a>

                                    </li>
                            @endif
                            <!-- End Logout -->

                            </ul>
                        </li>
                        <!-- End Leave -->

                    </ul>
                </div><!--/navbar-collapse-->
            </div>
        </div>

        <!-- End Navbar -->
    </div>

    <!--=== End Header ===-->

    <!--=== Profile ===-->
    <div class="profile container content">

        {{----------------MAINTENANCE CHECK----------------}}
        @include('maintenance_check')
        {{----------------MAINTENANCE CHECK----------------}}


        <div class="row">
            <!--Left Sidebar-->
            <div class="col-md-3 md-margin-bottom-40 @if(!isset($homeActive))hidden-sm hidden-xs @endif">
                {!! HTML::image($employee->profile_image_url,'ProfileImage',['class'=>"img-responsive profile-img margin-bottom-20",'style'=>'border:1px solid #ddd;margin:0 auto']) !!}


                {{--<img class="img-responsive profile-img margin-bottom-20" src="front_assets/img/team/5.jpg" alt="">--}}
                <p>
                <h3 class="text-center">{{$employee->full_name}}</h3>
                <h6 class="text-center">{{$employee->getDesignation->designation}}</h6>
                <h6 class="service-block-u" style="text-align: center;padding: 10px;">
                    <strong>{{__('core.atWorkFor')}} : </strong>{{ $employee->work_duration }}</h6>
                </p>
                <hr>
                <div class="service-block-v3 service-block-u">
                    <!-- STAT -->
                    <div class="row profile-stat">
                        <div class="col-md-4 col-sm-4 col-xs-6" data-toggle="tooltip" data-placement="bottom"
                             title="{!! date('F') !!}">
                            <div class="uppercase profile-stat-title">
                                {{$attendance_count}}
                            </div>
                            <div class="uppercase profile-stat-text">
                                {{__('core.attendance')}}
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6" data-toggle="tooltip" data-placement="bottom"
                             title="{{__('core.leaves')}}">
                            <div class="uppercase profile-stat-title">
                                {{$leaveLeft}}
                            </div>
                            <div class="uppercase profile-stat-text">
                                {{__('core.leaves')}}
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6" data-toggle="tooltip" data-placement="bottom"
                             title="{{__('core.totalAwardsWon')}}">
                            <div class="uppercase profile-stat-title">
                                {{count($employee->awards)}}
                            </div>
                            <div class="uppercase profile-stat-text">
                                {{__('core.awards')}}
                            </div>
                        </div>
                    </div>
                    <!-- END STAT -->
                </div>


                <!--Notification-->
                @if(count($current_month_birthdays)>0)
                    <div class="panel-heading-v2 overflow-h">
                        <h2 class="heading-xs pull-left"><i
                                    class="fa fa-birthday-cake"></i> {{__('core.birthdays')}}</h2>
                    </div>
                    <ul id="scrollbar5" class="list-unstyled contentHolder margin-bottom-20" style="height: auto">
                        @foreach($current_month_birthdays as $birthday)
                            <li class="notification">
                                {!! HTML::image($birthday->profile_image_url,'ProfileImage',['class'=>"rounded-x"]) !!}


                                <div class="overflow-h">
                                    <span><strong>{{$birthday->full_name}}</strong>  {{__('core.hasBirthDayOn')}}</span>
                                    <strong>{!! date('d F',strtotime($birthday->date_of_birth)) !!}</strong>
                                </div>
                            </li>
                        @endforeach

                    </ul>
            @endif
            <!--End Notification-->


                <div class="margin-bottom-50"></div>
            </div>
            <!--End Left Sidebar-->

            {{--------------------Main Area----------------}}
            @yield('mainarea')
            {{---------------Main Area End here------------}}


        </div><!--/end row-->


    </div>
    <!--=== End Profile ===-->

    <!--=== Footer Version 1 ===-->
    <div class="footer-v1">

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <p style="text-align: center;">
                            {!! date('Y') !!} &copy; {{$setting->company_name}}

                        </p>
                    </div>

                    <!-- Social Links -->
                    <div class="col-md-4">

                    </div>
                    <!-- End Social Links -->
                </div>
            </div>
        </div><!--/copyright-->
    </div>
    <!--=== End Footer Version 1 ===-->


    {{--------------------------Apply Leave  MODALS-----------------------------}}

    <div class="modal fade apply_modal in" id="applyLeave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


            </div>
        </div>
    </div>
    {{------------------------Apply Leave MODALS-------------------------}}


    {{--------------------------Change Password  MODALS-----------------------------}}
    <div class="modal fade change_password_modal in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">
                        {{__('menu.changePassword')}}
                    </h4>
                </div>
                <div class="modal-body" id="change_password_modal_body">
                    {{--Load with Ajax call--}}

                </div>
            </div>
        </div>
    </div>
    {{------------------------Change Password  MODALS-------------------------}}


</div><!--/wrapper-->

<script src="https://cdn.ravenjs.com/2.1.0/raven.min.js" rel="core"></script>

<!-- JS Global Compulsory -->
{!! HTML::script('front_assets/plugins/jquery/jquery.min.js') !!}
{!! HTML::script('front_assets/plugins/jquery/jquery-migrate.min.js') !!}
{!! HTML::script('front_assets/plugins/bootstrap/js/bootstrap.min.js') !!}

<!-- JS Implementing Plugins -->
{!! HTML::script('front_assets/plugins/back-to-top.js') !!}

<!-- Scrollbar -->
{!! HTML::script('front_assets/plugins/scrollbar/src/jquery.mousewheel.js') !!}
{!! HTML::script('front_assets/plugins/scrollbar/src/perfect-scrollbar.js') !!}
<!-- JS Customization -->
{!! HTML::script('front_assets//plugins/sky-forms/version-2.0.1/js/jquery-ui.min.js') !!}
{!! HTML::script('front_assets/plugins/sky-forms/version-2.0.1/js/jquery.form.min.js') !!}
<!-- JS Page Level -->
{!! HTML::script('front_assets/plugins/lib/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')!!}
{!! HTML::script('assets/global/plugins/froiden-helper/helper.js')!!}
@yield('footerjs')

<!--[if lt IE 9]>
{!! HTML::script('front_assets/plugins/respond.js') !!}
{!! HTML::script('front_assets/plugins/html5shiv.js') !!}
<![endif]-->
<script>
    jQuery(document).ready(function ($) {
        "use strict";
        $('.contentHolder').perfectScrollbar();

        /*$('#start_date').datepicker({
            dateFormat: 'dd/mm/yy',
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            minDate: 0,

            onSelect: function (selectedDate) {

                var diff = ($("#end_date").datepicker("getDate") -
                    $("#start_date").datepicker("getDate")) /
                    1000 / 60 / 60 / 24 + 1; // days
                if ($("#end_date").datepicker("getDate") != null) {
                    $('#daysSelected').html(diff);
                    $('#days').val(diff);
                }
                $('#end_date').datepicker('option', 'minDate', selectedDate);
            }
        });
        $('#end_date').datepicker({
            dateFormat: 'dd/mm/yy',
            prevText: '<i class="fa fa-angle-left"></i>',
            nextText: '<i class="fa fa-angle-right"></i>',
            onSelect: function (selectedDate) {

                $('#start_date').datepicker('option', 'maxDate', selectedDate);

                var diff = ($("#end_date").datepicker("getDate") -
                    $("#start_date").datepicker("getDate")) /
                    1000 / 60 / 60 / 24 + 1; // days
                if ($("#start_date").datepicker("getDate") != null) {
                    $('#daysSelected').html(diff);
                    $('#days').val(diff);
                }

            }
        });*/

    });

    function leaveModal() {
        $.ajaxModal('#applyLeave', '{{route('leaves.create')}}');
    }
</script>


<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    $('input[type=checkbox]').uniform();


    // Show change password modal body
    $('#change_password_link').click(function () {

        $('#change_password_modal_body').css("padding", "100px");
        $('#change_password_modal_body').html('{!! HTML::image('front_assets/img/loader.gif') !!}');
        $('#change_password_modal_body').attr('class', 'text-center');

        $.ajax({
            type: 'POST',
            url: "{{route('front.change_password_modal')}}",

            data: {},
            success: function (response) {

                $('#change_password_modal_body').css("padding", "0px");
                $('#change_password_modal_body').removeClass('text-center');
                $('#change_password_modal_body').html(response);
            },

            error: function (xhr, textStatus, thrownError) {
                $('#change_password_modal_body').html('<div class="alert alert-danger">Error Fetching data</div>');
            }
        });

    });

    function change_password() {
        $.easyAjax({
            type: 'POST',
            url: "{{route('front.change_password')}}",
            data: $('#change_password_form').serialize(),
            container: "#change_password_form",
            success: function (response) {
                if (response.status === "success") {
                    $('.change_password_modal').modal('hide');
                }
            }
        });
        return false;
    }


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
</body>
</html>
