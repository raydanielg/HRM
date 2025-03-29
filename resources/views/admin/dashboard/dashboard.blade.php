@extends('admin.adminlayouts.adminlayout')

@section('head')
    {!! HTML::style("assets/global/plugins/fullcalendar/fullcalendar.min.css") !!}
@stop

@section('mainarea')

    <div class="page-head">
        <div class="page-title">
            <h1>
                <b style="font-weight: 400">@if($loggedAdmin->type=='superadmin'){{ $loggedAdmin->company->company_name }} @endif</b> {{ trans('core.dashboard') }}
            </h1>
        </div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <span class="active">{{ trans('core.dashboard') }}</span>
            </li>
        </ul>

    </div>
    @if ($loggedAdmin->company->license_expired == 1)
        <div class="row">
            <div class="col-md-12">
                <div class="note note-danger"><i class="fa fa-close"></i> You have unpaid invoices past due date. Please
                    pay them by going to Settings > Billing to restore access to your account.
                </div>
            </div>
        </div>
    @endif

    @if ($loggedAdmin->company->license_expired == 0)
        @if (($displaySetup == true and $nextStepNumber > 3) || $displaySetup == false)
            @if(!$loggedAdmin->checkEmailVerified())
                <div class="row">
                    <div class="col-md-12">
                        <div class="note note-danger"><i
                                    class="fa fa-close"></i> {!! trans("messages.verifyEmail", ["link" => URL::to('admin/resend_verify_email')]) !!}
                        </div>
                    </div>
                </div>
            @endif

            @if($loggedAdmin->company->billing_address == "")
                <div class="row">
                    <div class="col-md-12">
                        <div class="note note-danger"><i class="fa fa-close"></i> Please update your billing address and
                            timezone by going to <a href="{{ route('admin.general_setting.edit') }}">company
                                settings</a>.
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endif

    @if($loggedAdmin->company->license_expired == 0)
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number count">
                            {{$employee_count}}
                        </div>
                        <div class="desc">
                            {{ trans('core.totalEmployees') }}
                        </div>
                    </div>
                    <a class="more" onclick="loadView('{{route('admin.employees.index') }}')">
                        {{ trans('core.viewMore') }} <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="details">
                        <div class="number count">
                            {{$department_count}}
                        </div>
                        <div class="desc">
                            {{ trans('core.totalDepartments') }}
                        </div>
                    </div>
                    <a class="more" onclick="loadView('{{route('admin.departments.index') }}')">
                        {{ trans('core.viewMore') }} <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

            @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->award_feature==1)
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green-haze">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number count">
                                {{$awards_count}}
                            </div>
                            <div class="desc">
                                {{ trans('core.totalAwards') }}
                            </div>
                        </div>
                        <a class="more" onclick="loadView('{{ route('admin.awards.index') }}')">
                            {{ trans('core.viewMore') }} <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            @endif

        </div>
        @if ($displaySetup == true)
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption ">
                                {{--<i class="fa fa-cogs"></i>--}}
                                @lang("core.welcomeTitle")
                            </div>
                        </div>
                        <div class="portlet-body">
                            <p>@lang("core.welcomeMessage")</p>
                            <hr>
                            <p style="font-weight: bold; font-size: 16px;">@lang("core.step") {{ $nextStepNumber }}: <a
                                        href="javascript:;" onclick="loadView('{{ $nextStepLink }}')">{{ $nextStep }} <i
                                            class="fa fa-arrow-circle-o-right"></i> </a></p>
                            <div class="progress progress-striped  margin-bottom-5">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="{{ round(($nextStepNumber - 1)/$totalSteps*100) }}"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width: {{ round(($nextStepNumber - 1)/$totalSteps*100) }}%">
                                    <span class="sr-only"> {{ round(($nextStepNumber - 1)/$totalSteps*100) }}% Complete </span>
                                </div>
                            </div>
                            <span><strong>@lang("core.progress")</strong>: {{ round(($nextStepNumber - 1)/$totalSteps*100)  }}% @lang("core.complete")</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">


            @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->attendance_feature==1)
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red">
                                <i class="icon-users font-red"></i>
                                {{ trans('core.attendance') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="calendar" class="has-toolbar">
                            </div>
                        </div>

                    </div>
                </div>
            @endif
            @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->expense_feature==1)
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-blue">
                                {{$loggedAdmin->company->currency_symbol}}
                                {{ trans('core.expenseReport') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="expenseChart" style="width: 100%; height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>

                </div>
            @endif
        </div>

        <div class="row ">
            <div class="col-md-6 col-sm-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="fa fa-birthday-cake font-dark"></i>{{ trans("core.".date('F')) }} {{ trans('core.birthdays') }}
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">


                                @forelse($current_month_birthdays as $birthday)
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm">
                                                        {!! HTML::image($birthday->profile_image_url,'ProfileImage',['class'=>"rounded-x",'height'=>'25px'])!!}
                                                    </div>
                                                </div>

                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        <span><strong>{{$birthday->full_name}}</strong>  {{ trans('core.hasBirthDayOn') }}</span>
                                                        <strong>{{date('d F ',strtotime($birthday->date_of_birth)) }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </li>

                                @empty
                                    <p class="text-center"
                                       style="padding: 4px; margin-top: 26%;">{{ trans('messages.noBirthdays') }}</p>
                                @endforelse

                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            @if($loggedAdmin->type=='superadmin' || $loggedAdmin->company->award_feature==1)
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="fa fa-trophy font-dark"></i>{{ trans('core.awards') }}
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">


                                    @forelse($awards as $award)


                                        <li>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm ">
                                                            {!! HTML::image($award->employee->profile_image_url,'ProfileImage',['class'=>"rounded-x",'height'=>'25px'])!!}

                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc">
                                                            {{\Illuminate\Support\Str::words($award->employee->full_name,1,'') }}
                                                            <span class="label label-sm label-info ">
            														{{$award->award_name}}
            														</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                    {{ucfirst($award->month) }} {{$award->year}}
                                                </div>
                                            </div>
                                        </li>

                                    @empty
                                        <p class="text-center"
                                           style="padding: 4px; margin-top: 26%;">{{ trans("messages.noAwards") }}</p>
                                    @endforelse


                                </ul>
                            </div>

                            <div class="scroller-footer">
                                <div class="btn-arrow-link pull-right">
                                    <a onclick="loadView('{{ route('admin.awards.index') }}')">{{ trans('core.seeAll') }}</a>
                                    <i class="icon-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>






    @endif
    <!-- END DASHBOARD STATS -->
@stop

@section('footerjs')
    @if($loggedAdmin->company->license_expired == 0)

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {!! HTML::script("assets/global/plugins/moment.min.js")!!}
        {!! HTML::script("assets/global/plugins/fullcalendar/fullcalendar.min.js")!!}
        {!! HTML::script("assets/global/plugins/fullcalendar/lang-all.js")!!}
        {!! HTML::script("assets/global/plugins/highcharts/js/highcharts.js")!!}
        {!! HTML::script("assets/global/plugins/highcharts/js/modules/exporting.js")!!}

        <script>

            var Calendar = function () {


                return {
                    //main function to initiate the module
                    init: function () {
                        Calendar.initCalendar();


                    },

                    initCalendar: function () {

                        if (!jQuery().fullCalendar) {
                            return;
                        }

                        var date = new Date();
                        var d = date.getDate();
                        var m = date.getMonth();
                        var y = date.getFullYear();

                        var h = {};


                        if ($('#calendar').parents(".portlet").width() <= 720) {

                            $('#calendar').addClass("mobile");
                            h = {
                                left: 'title, prev, next',
                                center: '',
                                right: 'today,month'
                            };
                        } else {
                            $('#calendar').removeClass("mobile");
                            h = {
                                left: 'title',
                                center: '',
                                right: 'prev,next,today'
                            };
                        }

                        $('#calendar').fullCalendar('destroy'); // destroy the calendar
                        $('#calendar').fullCalendar({ //re-initialize the calendar
                            lang: '{{ Lang::getLocale() }}',
                            header: h,
                            defaultView: 'month',
                            eventRender: function (event, element, view) {

                                var i = document.createElement('i');
                                // Add all your other classes here that are common, for demo just 'fa'
                                i.className = 'fa';
                                /*'ace-icon fa yellow bigger-250 '*/
                                i.classList.add(event.icon);
                                element.find('div.fc-content').prepend(i);


                                if (event.className == "holiday") {
                                    var dataToFind = moment(event.start).format('YYYY-MM-DD');
                                    $('.fc-day[data-date="' + dataToFind + '"]').css('background', '#fcebb6');
                                }
                            },
                            events: function (start, end, timezone, callback) {
                                jQuery.ajax({
                                    url: '{{route('admin.attendance.ajax_load_calender') }}',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        start: start.format(),
                                        end: end.format()

                                    },
                                    success: function (doc) {
                                        var events = [];
                                        if (!!doc) {
                                            $.map(doc, function (r) {

                                                if (r.type == "attendance") {
                                                    type = r.type;

                                                    if (r.title == "all present") {
                                                        icon = 'fa-check';
                                                        bgcolor = '';
                                                    } else {
                                                        icon = 'no';
                                                        bgcolor = '#e50000';
                                                    }

                                                    eClassName = '';
                                                } else if (r.type == 'birthday') {
                                                    type = r.type;
                                                    icon = 'fa-birthday-cake';
                                                    bgcolor = 'green';
                                                    eClassName = ''
                                                } else {
                                                    type = 'holiday';
                                                    icon = 'fa-tree';
                                                    bgcolor = '#444D58';
                                                    eClassName = 'holiday'
                                                }
                                                events.push({
                                                    className: eClassName,
                                                    icon: icon,
                                                    type: type,
                                                    color: bgcolor,
                                                    id: r.id,
                                                    title: r.title,
                                                    start: r.date

                                                });
                                            });
                                        }
                                        callback(events);
                                    }
                                });
                            }

                        });
                    }
                };
            }();

            $(function () {

                $('#expenseChart').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '{{ trans('core.monthlyExpenseReport') }} ' + new Date().getFullYear()
                    },
                    xAxis: {
                        categories: [
                            '{{ trans('core.jan') }}',
                            '{{ trans('core.feb') }}',
                            '{{ trans('core.mar') }}',
                            '{{ trans('core.apr') }}',
                            '{{ trans('core.may') }}',
                            '{{ trans('core.june') }}',
                            '{{ trans('core.july') }}',
                            '{{ trans('core.aug') }}',
                            '{{ trans('core.sept') }}',
                            '{{ trans('core.oct') }}',
                            '{{ trans('core.nov') }}',
                            '{{ trans('core.dec') }}'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            useHTML: true,
                            text: '{{ trans('core.expense') }} ({!! $loggedAdmin->company->currency_symbol !!})'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} {{$loggedAdmin->company->currency_symbol}}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: '{{  trans('core.expense') }}',
                        data: [{!! $expense !!} ]

                    }]
                });
            });

            jQuery(document).ready(function () {
                Calendar.init();
            });
        </script>
        <script>
            $('.count').each(function () {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        </script>
    @endif
@stop
