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
                        {{---------------------------------------Company Settings-------------------------------}}
                    <li class="nav-item {{ isset($billingActive) ? $billingActive : ''}}">
                        <a class="nav-link"
                           href="javascript: loadView('{{route('admin.billing.change_plan')}}')">
                            <i class="fa fa-dollar"></i>
                            {{__('menu.billing')}}
                            @if($unpaid_invoices > 0)
                                <span class="badge badge-danger">{{ $unpaid_invoices }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
</div>
<!-- END HEADER -->
