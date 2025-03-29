@extends('front.layouts.frontlayout')

@section('mainarea')


    <div class="col-md-9">
        @if ($active_company->license_expired == 1)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger"><i class="fa fa-close"></i> Your companies account has been
                        disabled. Please contact your manager for further details.
                    </div>
                </div>
            </div>
    @endif
    @if ($active_company->license_expired != 1)
        <!--Profile Body-->
            <div class="profile-body">
                <div class="row margin-bottom-20">
                    <!--Profile Post-->
                    <div class="col-sm-6">
                        <div class="panel panel-profile no-bg">
                            <div class="panel-heading overflow-h  service-block-u">
                                <h2 class="panel-title heading-sm pull-left"><i
                                            class="fa fa-user"></i>{{__('core.personalDetails')}}</h2>
                            </div>
                            <div class="panel-body panelHolder">
                                <table class="table table-light margin-bottom-0">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.name')}}</span>
                                        </td>
                                        <td>
                                            {{$employee->full_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.father_name')}}</span>
                                        </td>
                                        <td>
                                            {{$employee->father_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.dob')}}</span>
                                        </td>
                                        <td>
                                            {!!  date('d-M-Y',strtotime($employee->date_of_birth)) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.gender')}}</span>
                                        </td>
                                        <td>
                                            {{ucfirst($employee->gender)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.email')}}</span>
                                        </td>
                                        <td>
                                            {{$employee->email}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.phone')}}</span>
                                        </td>
                                        <td>
                                            {{$employee->mobile_number}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.local_address')}}</span>
                                        </td>
                                        <td>
                                            {{$employee->local_address}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.permanent_address')}}</span>
                                        </td>
                                        <td>
                                            {{$employee->permanent_address}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-profile no-bg margin-top-20">
                            <div class="panel-heading overflow-h service-block-u">
                                <h2 class="panel-title heading-sm pull-left"><i
                                            class="fa fa-briefcase"></i>{{__('core.companyDetails')}}</h2>
                            </div>
                            <div class="panel-body panelHolder">
                                <table class="table table-light margin-bottom-0">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.employeeID')}}</span>
                                        </td>
                                        <td>
                                            {{ $employee->employeeID }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.department')}}</span>
                                        </td>
                                        <td>
                                            {{ $employee->getDesignation->department->name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.designation')}}</span>
                                        </td>
                                        <td>
                                            {{$employee->getDesignation->designation}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.dateOfJoining')}}</span>
                                        </td>
                                        <td>
                                            {!! date('d-M-Y',strtotime($employee->joining_date)) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.salary')}} ( {{$setting->currency_symbol}} )</span>
                                        </td>
                                        <td>

                                            @foreach($employee->salaries as $salary)
                                                <p>@trans('core.'.$salary->type)
                                                    : {{$salary->salary}} {{$setting->currency_symbol}} </p>
                                            @endforeach
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-profile no-bg margin-top-20">
                            <div class="panel-heading overflow-h service-block-u">
                                <h2 class="panel-title heading-sm pull-left"><i
                                            class="fa fa-bank"></i>{{__('core.bankDetails')}}</h2>
                            </div>
                            <div class="panel-body panelHolder">
                                <table class="table table-light margin-bottom-0">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.accountHolder')}}</span>
                                        </td>
                                        <td>
                                            {{isset($employee->bank_details->account_name) ? $employee->bank_details->account_name : ''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.account_number')}}</span>
                                        </td>
                                        <td>
                                            {{isset($employee->bank_details->account_number) ? $employee->bank_details->account_number : ''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.bank')}}</span>
                                        </td>
                                        <td>
                                            {{isset($employee->bank_details->bank) ? $employee->bank_details->bank : ''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.bsb')}}</span>
                                        </td>
                                        <td>
                                            {{isset($employee->bank_details->bsb) ? $employee->bank_details->bsb : ''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.tax_payer_id')}}</span>
                                        </td>
                                        <td>
                                            {{isset($employee->bank_details->tax_payer_id) ? $employee->bank_details->tax_payer_id : ''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.bin')}}</span>
                                        </td>
                                        <td>
                                            {{isset($employee->bank_details->bin) ? $employee->bank_details->bin : ''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="primary-link">{{__('core.branch')}}</span>
                                        </td>
                                        <td>
                                            {{isset($employee->bank_details->branch) ? $employee->bank_details->branch : ''}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Profile Post-->

                    <!--Notice Board -->

                    <div class="col-sm-6 md-margin-bottom-20">
                        @if($setting->notice_feature==1)
                            <div class="panel panel-profile  margin-bottom-20">
                                <div class="panel-heading overflow-h service-block-u">
                                    <h2 class="panel-title heading-sm pull-left"><i
                                                class="fa fa-bullhorn"></i>{{__('core.noticeBoard')}}</h2>
                                </div>
                                <div id="scrollbar2" class="panel-body contentHolder">

                                    @forelse($noticeboards as $notice)
                                        <div class="profile-event">
                                            <div class="date-formats">
                                                <span>{!! date('d',strtotime($notice->created_at)) !!}</span>
                                                <small>{!! date('m, Y',strtotime($notice->created_at)) !!}</small>
                                            </div>
                                            <div class="overflow-h">
                                                <h3 class="heading-xs"><a href="" data-toggle="modal"
                                                                          data-target=".show_notice"
                                                                          onclick="show_notice({{$notice->id}});return false;">{{$notice->title}}</a>
                                                </h3>
                                                @if(strpos($notice->description,'src')==0)
                                                    <p>{!!  \Illuminate\Support\Str::limit(strip_tags($notice->description),100) !!}</p>
                                                @else
                                                    <p>&nbsp;</p>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center" style="padding: 4px; margin-top: 26%;">No Notice</p>
                                    @endforelse

                                </div>
                            </div>
                        @endif

                        @if($setting->holidays_feature==1)
                            <div class="panel panel-profile">
                                <div class="panel-heading overflow-h service-block-u">
                                    <h2 class="panel-title heading-sm pull-left"><i
                                                class="fa fa-send"></i> {{__('core.upcomingHolidays')}}</h2>
                                </div>
                                <div id="scrollbar3" class="panel-body contentHolder">

                                    @forelse($holidays as $holiday)
                                        {{--Check for upcoming Holidays--}}
                                        @if(strtotime($holiday->date)>time())
                                            <div class="alert-blocks alert-blocks-{{$holiday_color[$holiday->id%count($holiday_color)]}}">
                                                <div class="overflow-h">
                                                    <strong class="color-{{$holiday_font_color[$holiday->id%count($holiday_font_color)]}}">{{$holiday->occassion}}
                                                        <small class="pull-right">
                                                            <em>{!! date('d M Y',strtotime($holiday->date)) !!}</em>
                                                        </small>
                                                    </strong>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <p class="text-center" style="padding: 4px; margin-top: 26%;">No Holiday</p>
                                    @endforelse

                                </div>
                            </div>
                        @endif
                        @if($setting->award_feature==1)
                            <div class="panel panel-profile margin-top-20">
                                <div class="panel-heading overflow-h service-block-u">
                                    <h2 class="panel-title heading-sm pull-left"><i
                                                class="fa fa-trophy"></i> {{__('core.awards')}}</h2>
                                </div>
                                <div id="scrollbar3" class="panel-body contentHolder">

                                    @forelse($employee->awards as $award)
                                        <div class="alert-blocks">
                                            <div class="overflow-h">
                                                <strong class="color-dark">{!! \Illuminate\Support\Str::words($award->employee->full_name,1,'') !!}
                                                    <small class="pull-right">
                                                        <em>{{ucfirst($award->month)}} {{$award->year}}</em>
                                                    </small>
                                                </strong>
                                                <small class="award-name">{{$award->award_name}}</small>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center" style="padding: 4px; margin-top: 26%;">No Award</p>
                                    @endforelse


                                </div>
                            </div>
                        @endif
                    </div>
                    <!--End Profile Event-->

                </div><!--/end row-->

                <hr>
            @if($setting->attendance_feature==1)
                <!--Profile Blog-->
                    <div class="panel panel-profile">
                        <div class="panel-heading overflow-h service-block-u">
                            <h2 class="panel-title heading-sm pull-left"><i
                                        class="fa fa-tasks"></i>{{__('core.attendance')}}</h2>
                        </div>
                        <div class="panel-body panelHolder">

                            <div class="alert-blocks alert-blocks-info">
                                <div class="overflow-h">
                                    <strong class="color-dark">{{__('core.lastAbsent')}}
                                        <small class="pull-right"><em>{!! $employee->lastAbsent('date') !!}</em></small>
                                    </strong>
                                    <small class="award-name">{!!  $employee->lastAbsent()!!}</small>
                                </div>
                            </div>

                            <div id='calendar'></div>

                        </div>
                    </div><!--/end row-->
            @endif

            <!--End Profile Blog-->

            </div>
            <!--End Profile Body-->
    </div>


    {{--------------------------Show Notice MODALS-----------------}}
    <div class="modal fade show_notice in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 id="myLargeModalLabel" class="modal-title show-notice-title">
                        {{--Notice Title using Javascript--}}
                    </h4>
                </div>
                <div class="modal-body" id="show-notice-body">
                    {{--Notice full Description using Javascript--}}
                </div>
            </div>
        </div>
    </div>
    {{------------------------END Notice MODALS---------------------}}
    @endif

@stop

@section('footerjs')
    @if ($active_company->license_expired != 1)
        {!! HTML::script('front_assets/plugins/fullcalendar/fullcalendar.min.js') !!}
        {!! HTML::script("front_assets/plugins/fullcalendar/lang-all.js") !!}

        <script>

            $(document).ready(function () {

                $('#calendar').fullCalendar({
                    lang: '{{Lang::getLocale()}}',

                    editable: false,
                    eventLimit: true, // allow "more" link when too many events
                    eventRender: function (event, element) {
                        var i = document.createElement('i');
                        // Add all your other classes here that are common, for demo just 'fa'
                        i.className = 'fa'; /*'ace-icon fa yellow bigger-250 '*/
                        i.classList.add(event.icon);
                        if (event.type == 'birthday') {
                            element.find('div.fc-content').prepend(i);
                        }
                        if (event.className == "holiday") {
                            var dataToFind = moment(event.start).format('YYYY-MM-DD');
                            $('.fc-day[data-date="' + dataToFind + '"]').css('background', 'rgba(255, 224, 205, 1)');
                        }
                    },
                    events: function (start, end, timezone, callback) {
                        jQuery.ajax({
                            url: '{{route('front.attendance.ajax_load_calender')}}',
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
                                        if (r.type == 'absent_other') {
                                            icon = 'no';
                                            type = r.type;
                                            etitle = r.title + "-" + r.leaveType;
                                            bgcolor = '#FF9800';
                                            eClassName = ''
                                        } else if (r.a_status == "absent") {
                                            icon = 'no';
                                            type = 'attendance';
                                            bgcolor = '#e50000';
                                            etitle = r.a_status + "-" + r.leaveType;
                                            eClassName = '';
                                        } else if (r.a_status == "present") {
                                            icon = 'no';
                                            type = 'attendance';
                                            bgcolor = '';
                                            etitle = r.a_status;
                                            eClassName = '';
                                        } else if (r.type == 'birthday') {
                                            icon = 'fa-birthday-cake';
                                            type = r.type;
                                            etitle = r.title;
                                            bgcolor = 'green';
                                            eClassName = ''
                                        } else {
                                            icon = 'no';
                                            type = 'holiday';
                                            etitle = r.title;
                                            bgcolor = 'grey';
                                            eClassName = 'holiday'
                                        }
                                        events.push({
                                            className: eClassName,
                                            color: bgcolor,
                                            'icon': icon,
                                            type: type,
                                            id: r.id,
                                            title: etitle,
                                            start: r.date

                                        });
                                    });
                                }
                                callback(events);
                            }
                        });
                    }


                });

            });

            function show_notice(id) {
                var url = "{{ route('front.notice_ajax',':id') }}";
                url = url.replace(':id', id);
                $.easyAjax({
                    url: url,
                    type: "GET",
                    data: $(".ajax_form").serialize(),
                    container: ".ajax_form",
                    success: function (response) {

                        $('.show-notice-title').html(response.title);
                        $('#show-notice-body').html(response.description);

                    },
                });
            }


        </script>
    @endif
@stop
