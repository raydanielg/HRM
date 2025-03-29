<!-- BEGIN HEADER -->
{{--{{ dd($loggedAdmin) }}--}}

<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="javascript:;">
                @if(admin()->type =='admin')
                    <img src="{{ $loggedAdmin->company->logo_image_url }}" height="50px">
                @else
                    <img src="{{ $setting->logo_image_url }}" height="50px">
                @endif

            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>
        <!-- END LOGO -->
        <div class="page-actions hidden-xs">
            @if ($loggedAdmin->company && $displaySetup == true && !Route::is("admin.dashboard.index") && $loggedAdmin->company->license_expired != 1 && $loggedAdmin->type !=='superadmin')
                <div class="btn-group hidden-sm hidden-xs" style="margin-top: -5px;">
                    <a href="{{ $nextStepLink }}" class="btn btn-sm dropdown-toggle btn-outline">
                        <span class=""><strong>@lang("core.nextStep")</strong>: {{ $nextStep }} <i
                                    class="fa fa-arrow-right"></i> </span>
                        <div class="progress progress-striped  margin-bottom-5" style="height: 5px">
                            <div class="progress-bar progress-bar-info" role="progressbar"
                                 aria-valuenow="{{ round(($nextStepNumber - 1)/$totalSteps*100) }}" aria-valuemin="0"
                                 aria-valuemax="100"
                                 style="width: {{ round(($nextStepNumber - 1)/$totalSteps*100) }}%;">
                                <span class="sr-only"> {{ round(($nextStepNumber - 1)/$totalSteps*100) }}
                                    % Complete </span>
                            </div>
                        </div>
                    </a>
                </div>
            @elseif ($displaySetup != true)
                <div class="btn-group">

                    @if(App::isDownForMaintenance())
                        <a href="#" class="btn red-intense btn-sm dropdown-toggle" style="margin-left: 10px">
                            <i class="fa fa-exclamation-circle"></i> Maintenance Mode
                        </a>
                    @endif
                </div>
            @endif
        </div>
        <!-- BEGIN TOP NAVIGATION MENU -->

        <div class="page-top">
            <div class="top-menu">

                <ul class="nav navbar-nav pull-right">
                    @if ($loggedAdmin->company && $loggedAdmin->company->license_expired != 1)
                        @if(isset($pending_applications))
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                   data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>

                                    @if(count($pending_applications))
                                        <span class="badge badge-default">
											{{count($pending_applications)}}
                            </span>
                                    @endif

                                </a>


                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3><span class="bold">{{count($pending_applications)}} pending</span>
                                            notifications</h3>

                                    </li>
                                    @if(count($pending_applications))
                                        <li>
                                            <ul class="dropdown-menu-list scroller" style="height: 250px;"
                                                data-handle-color="#637283">
                                                @forelse($pending_applications as $pending)
                                                    <li>
                                                        <a data-toggle="modal" href="#static_leave_requests"
                                                           onclick="show_application_notification({{ $pending->id }});return false;">
                                                            <span class="time">{{date('d-M-Y',strtotime($pending->created_at))}}</span>
                                                            <span class="details">
                									<span class="label label-sm label-icon label-success">
                									<i class="fa fa-bell-o"></i>
                									</span>
                									 <strong>{{$pending->employee->full_name}} </strong> has applied for leave for @if(!isset($pending->end_date))
                                                                    {{date('d-M-Y',strtotime($pending->start_date))}}
                                                                @else
                                                                    {{date('d-M-Y',strtotime($pending->start_date))}}
                                                                    to  {{date('d-M-Y',strtotime($pending->end_date))}}
                                                                @endif
                                                    </span>
                                                        </a>
                                                    </li>
                                                @empty
                                                    <li>
                                                    </li>
                                                @endforelse


                                            </ul>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                    {{--Company--}}

                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">


                                <span class="username hidden-sm hidden-xs">
                  {{ $loggedAdmin->name }}</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{route(admin()->type.'.profile_settings.edit')}}">
                                    <i class="icon-user"></i> {{trans('menu.myProfile')}}</a>
                            </li>

                            <li class="divider">
                            </li>
                            <li>
                                <a onclick="lockScreenModal()">
                                    <i class="icon-lock"></i> {{trans('menu.lockScreen')}} </a>
                            </li>
                            <li>
                                <a href="{{ URL::route('admin.logout') }} " id="logout-form">
                                    <i class="icon-logout"></i> {{trans('menu.logout')}} </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->

                </ul>
            </div>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
    <div class="page-header-menu">
        <div class="container-fluid">
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN MEGA MENU -->
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
            <div class="hor-menu ">
                <ul class="nav navbar-nav">
                    @if($loggedAdmin->type=='superadmin')
                        @include('admin.include.superadmin_menu')

                    @endif
                    {{--SHOW IF THERE IS COMPANY IN DATABASE--}}
                    @if(isset($loggedAdmin->company) && $loggedAdmin->type !=='superadmin')
                        @if ($loggedAdmin->company->license_expired  == 0)
                            {{---------------------------------------Dashboard-------------------------------}}
                            <li class="nav-item  @if($loggedAdmin->type=='admin')start @endif {{ isset($dashboardActive) ? $dashboardActive : ''}}">
                                <a class="nav-link" href="javascript: loadView('{{URL::to('admin')}}')">
                                    <i class="icon-home"></i>
                                    <span class="title">{{__('menu.dashboard')}}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            {{---------------------------------------/Dashboard-------------------------------}}

                            <li class="menu-dropdown classic-menu-dropdown {{ isset($peopleMenuActive) ? $peopleMenuActive : '' }}">
                                <a href="javascript:;">
                                    <i class="icon-user"></i> People
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    @if($loggedAdmin->manager!=1)
                                        <li class=" {{ isset($departmentActive) ? $departmentActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.departments.index')}}')">
                                                <i class="fa fa-bookmark"></i>
                                                {{__('menu.department')}}</a>
                                        </li>
                                        {{--<li class=" {{ isset($managersActive) ? $managersActive : ''}}">--}}
                                        {{--<a class="nav-link"--}}
                                        {{--href="javascript: loadView('{{route('admin.managers.index')}}')">--}}
                                        {{--<i class="fa fa-briefcase"></i>--}}
                                        {{--{{__('menu.managers')}}</a>--}}
                                        {{--</li>--}}
                                    @else
                                        <li class="nav-item {{ isset($departmentActive) ? $departmentActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.departments.index')}}')">
                                                <i class="fa fa-briefcase"></i>
                                                <span class="title">{{__('menu.department')}}</span>
                                                <span class="selected"></span>
                                            </a>

                                        </li>
                                    @endif
                                    <li class="nav-item {{ isset($employeesActive) ? $employeesActive : ''}}">
                                        <a class="nav-link"
                                           href="javascript: loadView('{{route('admin.employees.index')}}')">
                                            <i class="fa fa-user"></i>
                                            <span class="title">{{__('menu.employees')}}</span>
                                            <span class="selected"></span>

                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="menu-dropdown classic-menu-dropdown {{ isset($hrMenuActive) ? $hrMenuActive : '' }}">
                                <a href="javascript:;">
                                    <i class="icon-briefcase"></i> HR
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    {{---------------------------------------Awards-------------------------------}}
                                    @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->award_feature==1)
                                        <li class="nav-item {{ isset($awardsActive) ? $awardsActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.awards.index')}}')">
                                                <i class="fa fa-trophy"></i>
                                                <span class="title">{{__('menu.award')}}</span>
                                                <span class="selected"></span>
                                            </a>

                                        </li>
                                    @endif
                                    {{---------------------------------------/Awards-------------------------------}}


                                    @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->expense_feature==1)
                                        {{---------------------------------------Expense-------------------------------}}
                                        <li class="nav-item {{ isset($expensesActive) ? $expensesActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.expenses.index')}}')">
                                                <i class="fa fa-money"></i>
                                                <span class="title">{{__('menu.expense')}}</span>
                                                <span class="selected"></span>
                                            </a>

                                        </li>
                                    @endif
                                    {{---------------------------------------/Expense-------------------------------}}

                                    @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->holidays_feature==1)
                                        {{---------------------------------------Holidays-------------------------------}}
                                        <li class="nav-item {{ isset($holidayActive) ? $holidayActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.holidays.index')}}')">
                                                <i class="fa fa-send"></i>
                                                <span class="title">{{__('menu.holiday')}}</span>
                                                <span class="selected"></span>
                                            </a>
                                        </li>
                                    @endif
                                    {{---------------------------------------/Holiday-------------------------------}}
                                    @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->payroll_feature==1)
                                        {{---------------------------------------Payroll -------------------------------}}
                                        <li class="nav-item {{ isset($payrollActive) ? $payrollActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.payrolls.index')}}')">
                                                &nbsp; {{$loggedAdmin->company->currency_symbol}} &nbsp;
                                                <span class="title">{{__('menu.payroll')}}</span>
                                                <span class="selected "></span>
                                            </a>

                                        </li>
                                    @endif

                                    {{---------------------------------------/Payroll-------------------------------}}


                                    @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->notice_feature==1)
                                        {{---------------------------------------Notice Board-------------------------------}}
                                        <li class="nav-item {{ isset($noticeBoardActive) ? $noticeBoardActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.noticeboards.index')}}')">
                                                <i class="fa fa-quote-left"></i>
                                                <span class="title">{{__('menu.noticeBoard')}}</span>
                                                <span class="selected "></span>
                                            </a>

                                        </li>
                                    @endif
                                    {{---------------------------------------/Notice Board-------------------------------}}
                                </ul>
                            </li>



                            @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->attendance_feature==1)
                                {{---------------------------------------Attendance-------------------------------}}
                                <li class="menu-dropdown classic-menu-dropdown {{ isset($attendanceOpen) ? $attendanceOpen : '' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-users"></i>
                                        <span class="title">{{__('menu.attendance')}}</span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item {{ isset($markAttendanceActive) ? $markAttendanceActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.attendances.create')}}')">
                                                <i class="fa  fa-check"></i>
                                                {{__('menu.markAttendance')}}</a>
                                        </li>
                                        <li class="nav-item {{ isset($viewAttendanceActive) ? $viewAttendanceActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.attendances.index')}}')">
                                                <i class="fa fa-eye"></i>
                                                {{__('menu.viewAttendance')}}</a>
                                        </li>
                                        @if($loggedAdmin->manager!=1)
                                            <li class="nav-item {{ isset($leaveTypeActive) ? $leaveTypeActive : ''}}">
                                                <a class="nav-link"
                                                   href="javascript: loadView('{{route('admin.leavetypes.index')}}')">
                                                    <i class="fa fa-sitemap"></i>
                                                    {{__('menu.leaveTypes')}}</a>
                                            </li>
                                        @endif
                                        @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->leave_feature==1)
                                            {{---------------------------------------Leave Applications-------------------------------}}
                                            <li class="nav-item {{ isset($leaveApplicationOpen) ? $leaveApplicationOpen : ''}}">
                                                <a class="nav-link"
                                                   href="javascript: loadView('{{route('admin.leave_applications.index')}}')">
                                                    <i class="fa fa-rocket"></i>
                                                    <span class="title">{{__('menu.leaveApplication')}}</span>
                                                    <span class="selected "></span>
                                                </a>

                                            </li>
                                        @endif

                                        {{---------------------------------------/Leave Applications-------------------------------}}
                                    </ul>
                                </li>
                            @endif

                            {{---------------------------------------/Attendance-------------------------------}}




                            @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->jobs_feature==1)
                                {{---------------------------------------Jobs -------------------------------}}
                                <li class="menu-dropdown classic-menu-dropdown {{ isset($jobsOpen) ? $jobsOpen : ''}}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="icon-graduation"></i>
                                        <span class="title">Recruitment</span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item {{ isset($jobsPostedActive) ? $jobsPostedActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.jobs.index')}}')">
                                                <i class="fa fa-ticket"></i>
                                                {{__('menu.jobsPosted')}}</a>
                                        </li>
                                        <li class="nav-item {{ isset($jobsApplicationActive) ? $jobsApplicationActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.job_applications.index')}}')">
                                                <i class="fa fa-file-text-o"></i>
                                                {{__('menu.jobApplications')}}</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            {{---------------------------------------/Job job_applications-------------------------------}}



                        @endif
                        {{---------------------------------------Company Settings-------------------------------}}
                        <li class="menu-dropdown classic-menu-dropdown {{ isset($csettingOpen) ? $csettingOpen : ''}}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">{{__('menu.settings')}}</span>
                                @if($unpaid_invoices > 0)
                                    <span class="badge badge-danger">{{ $unpaid_invoices }}</span>
                                @else
                                    <i class="fa fa-angle-down"></i>
                                @endif
                            </a>
                            <ul class="dropdown-menu pull-left">

                                @if($loggedAdmin->manager!=1)
                                    <li class="nav-item {{ isset($billingActive) ? $billingActive : ''}}">
                                        <a class="nav-link"
                                           href="javascript: loadView('{{ route('admin.billing.index') }}')">
                                            <i class="fa fa-dollar"></i>
                                            {{__('menu.billing')}}
                                            @if($unpaid_invoices > 0)
                                                <span class="badge badge-danger">{{ $unpaid_invoices }}</span>
                                            @endif
                                        </a>

                                    </li>
                                @endif
                                @if($loggedAdmin->company->license_expired == 0)
                                    @if($loggedAdmin->type!='superadmin')
                                        @if($loggedAdmin->manager!=1)
                                            <li class="nav-item {{ isset($csettingActive) ? $csettingActive : ''}}">
                                                <a class="nav-link"
                                                   href="javascript: loadView('{{ route('admin.general_setting.edit')}}')">
                                                    <i class="fa  fa-cog"></i>
                                                    {{__('menu.generalSetting')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if($loggedAdmin->type!='superadmin')
                                        <li class="nav-item {{ isset($profileSettingActive) ? $profileSettingActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.profile_settings.edit','profile')}}')">
                                                <i class="fa fa-user"></i>
                                                {{__('menu.profileSetting')}}</a>
                                        </li>
                                    @endif

                                    <li class="nav-item {{ isset($notificationSettingActive) ? $notificationSettingActive : ''}}">
                                        <a class="nav-link"
                                           href="javascript: loadView('{{route('admin.notification.edit')}}')">
                                            <i class="fa fa-bell"></i>
                                            {{__('menu.notificationSetting')}}</a>
                                    </li>

                                    @if($loggedAdmin->manager!=1)
                                        <li class="nav-item {{ isset($cthemeSettingActive) ? $cthemeSettingActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.company_setting.theme')}}')">
                                                <i class="icon-diamond"></i>
                                                {{__('menu.theme')}}</a>
                                        </li>

                                        <li class="nav-item {{ isset($adminSettingActive) ? $adminSettingActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.attendance_settings.edit')}}')">
                                                <i class="fa fa-gears"></i>
                                                Attendance Settings</a>
                                        </li>

                                        <li class="nav-item {{ isset($adminUserActive) ? $adminUserActive : ''}}">
                                            <a class="nav-link"
                                               href="javascript: loadView('{{route('admin.admin_users.index')}}')">
                                                <i class="icon-users"></i>
                                                {{__('menu.adminUser')}}</a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>

                    @endif
                    {{--SHOW IF ANY COMPANY IN DATABASE--}}
                </ul>
            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
</div>
<!-- END HEADER -->


{{--Leave Application view MODALS--}}
{!! Form::open(['url'=>'','id'=>'edit_form_leave','method'=>'PATCH']) !!}
<div id="static_leave_requests" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-data-leave">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase">Leave Application</span>
            </div>
            <div class="modal-body" id="load-data">
                {{--Ajax data call for form--}}
            </div>
        </div>

    </div>
</div>
{!!   Form::close() !!}
{{--Leave Modal Close--}}
{{--Screen Lock Modal Start--}}
<div id="static_screen_lock" class="modal fade" tabindex="-1" style="z-index: 999999;" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-data-leave">
            <div class="modal-header">
                <center>
                    <div class="reg-block-header">
                        <h2><img src="{{$setting->logo_image_url}}" height="50px"></h2>
                    </div>
                </center>
                <h2 class="text-center">{{ $loggedAdmin->name}}</h2>
                <h5 class="email text-center">
                    {{ $loggedAdmin->email}} </h5>
                <h5 class="locked text-center"><strong>Locked</strong></h5><br/>
            </div>
            <div class="modal-body" id="load-data">
                {!!  Form::open(array('url' => '','class' =>'form'))  !!}
                <div id='alert'></div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="input-group margin-bottom-20">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                       id="password">
                                <input type="hidden" class="form-control" name="email" value="{{ $loggedAdmin->email}}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn red" onclick="loginCheck();return false;"
                                            id="submitbutton" style="margin-left: 5px;"><i
                                                class="fa fa-arrow-circle-right"></i></button>
                                </span>
                            </div>
                            <!-- /input-group -->
                            <div class="relogin text-center">
                                <a href="{{ URL::to('admin/logout')}}">
                                    Not <strong>{{ $loggedAdmin->name}}</strong>? </a>
                            </div>
                        </div>
                    </div>


                </div>
                {!!  Form::close() !!}
            </div>
        </div>

    </div>
</div>
{{--Screen Lock Modal End--}}

<script>
    function show_application_notification(id) {
        $("#load-data").html('<div class="text-center">{!! HTML::image('assets/loader.gif') !!}</div>');
        $('#edit_form_leave').attr('action', "{!! URL::to('admin/leave_applications/"+id+"') !!}");
        $.ajax({
            type: "GET",
            url: "{!!  URL::to('admin/leave_applications/"+id+"')  !!}"

        }).done(function (response) {
            $('#modal-data-leave').html(response);
//
        });
    }

    function changeLanguage(lang) {
        $.ajax({
            type: 'GET',
            url: "{{route('admin.change_language')}}",
            dataType: "JSON",
            data: {
                'locale': lang
            },
            success: function (response) {
                if (response.success === 'success') {
                    window.location.reload();
                }

            },
            error: function (xhr, textStatus, thrownError) {

            }
        });
    }

    function changeCompany(com_id) {
        $.ajax({
            type: 'GET',
            url: "{{route('admin.change_company')}}",
            dataType: "JSON",
            data: {
                'company_id': com_id
            },
            success: function (response) {
                if (response.success === 'success') {
                    window.location.reload();
                }

            },
            error: function (xhr, textStatus, thrownError) {

            }
        });
    }
</script>
