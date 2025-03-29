@extends('admin.adminlayouts.adminlayout')

@section('head')
<!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")!!}
    {!! HTML::style("assets/global/plugins/fullcalendar/fullcalendar.min.css")!!}
<!-- BEGIN THEME STYLES -->
@stop

@section('mainarea')

			
			<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title">
        <h1>
            @lang("pages.attendances.indexTitle") - {{ $employee->full_name }}
        </h1>
    </div>
</div>
<div class="page-bar">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a onclick="loadView('{{ route('admin.dashboard.index') }}')" >@lang("core.dashboard")</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a onclick="loadView('{{ route('admin.attendances.index') }}')" >@lang("pages.attendances.indexTitle")</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">@lang("pages.attendances.editTitle")</span>
        </li>

    </ul>

</div>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">


        <div class="portlet light bordered calendar">
            <div class="portlet-title">
                <div class="caption font-green-meadow">
                    <i class="fa fa-user font-green-meadow"></i>{{ $employee->full_name }}
                </div>
            </div>
            <div class="portlet-body text-center">
                <div class="row ">

                    <div class="col-md-4 col-sm-4">
                        <h2>Select</h2>

                        <form role="form form-row-sepe">
                            <div class="form-body alert alert-block alert-info fade in">

                                <div class="row ">

                                    <div class="col-md-12 ">

                                        <div class="form-group">
                                            <label>@lang("core.employee")</label>
                                            <div class="input-group ">

                                                <select class="form-control select2me" name="employee_id" onchange="redirect_to()" id="changeEmployee">
                                                    @foreach($employeeslist as $employee)
                                                        <option value="{{$employee->id}}"
                                                                >{{$employee->full_name}} (EmpId: {{ $employee->employeeID }})</option>
                                                    @endforeach
                                                </select>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">

                                    <!--/span-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('core.month')}}</label>

                                            <div class="input-group">
                                                <select class="form-control input-large select2me monthSelect"
                                                        id="monthSelect" name="month"
                                                        onchange="changeMonthYear();return false;">
                                                    <option value="01"
                                                            @if(strtolower(date('F'))=='january')selected='selected'@endif>{{trans('core.January')}}</option>
                                                    <option value="02"
                                                            @if(strtolower(date('F'))=='february')selected='selected'@endif>{{trans('core.February')}}</option>
                                                    <option value="03"
                                                            @if(strtolower(date('F'))=='march')selected='selected'@endif>{{trans('core.March')}}</option>
                                                    <option value="04"
                                                            @if(strtolower(date('F'))=='april')selected='selected'@endif>{{trans('core.April')}}</option>
                                                    <option value="05"
                                                            @if(strtolower(date('F'))=='may')selected='selected'@endif>{{trans('core.May')}}</option>
                                                    <option value="06"
                                                            @if(strtolower(date('F'))=='june')selected='selected'@endif>{{trans('core.June')}}</option>
                                                    <option value="07"
                                                            @if(strtolower(date('F'))=='july')selected='selected'@endif>{{trans('core.July')}}</option>
                                                    <option value="08"
                                                            @if(strtolower(date('F'))=='august')selected='selected'@endif>{{trans('core.August')}}</option>
                                                    <option value="09"
                                                            @if(strtolower(date('F'))=='september')selected='selected'@endif>{{trans('core.September')}}</option>
                                                    <option value="10"
                                                            @if(strtolower(date('F'))=='october')selected='selected'@endif>{{trans('core.October')}}</option>
                                                    <option value="11"
                                                            @if(strtolower(date('F'))=='november')selected='selected'@endif>{{trans('core.November')}}</option>
                                                    <option value="12"
                                                            @if(strtolower(date('F'))=='december')selected='selected'@endif>{{trans('core.December')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('core.year')}}</label>
                                            <select class="form-control input-large select2me" id="yearSelect"
                                                    name="month" onchange="changeMonthYear();return false;">
                                                @for($i=2013;$i<=date('Y');$i++)
                                                    <option value="{{$i}}"
                                                            @if(date('Y')==$i) selected='selected'@endif>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <!--/span-->

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-danger text-center">
                                            <strong>{{trans('core.attendance')}}</strong>
                                            <div id="attendanceReport">-</div>
                                        </div>
                                    </div>
                                    <!--/span-->

                                    <div class="col-md-6">
                                        <div class="alert alert-danger text-center">
                                            <strong>{{trans('core.attendance')}} %</strong>

                                            <div id="attendancePerReport">-</div>
                                        </div>
                                    </div>
                                    <!--/span-->

                                </div>
                            </div>

                        </form>


                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div id="calendar" class="has-toolbar text-center"></div>
                    </div>
                </div>
                <!-- END CALENDAR PORTLET-->
            </div>
        </div>
    </div>
</div>            <!-- END PAGE CONTENT-->

@stop

@section('footerjs')

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
        {!! HTML::script("assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js")!!}
        {!! HTML::script("assets/global/plugins/select2/js/select2.js")!!}
        {!! HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")!!}
        {!! HTML::script("assets/admin/pages/scripts/components-dropdowns.js")!!}
		{!! HTML::script('assets/admin/pages/scripts/ui-blockui.js')!!}
        {!! HTML::script("assets/global/plugins/moment.min.js")!!}
        {!! HTML::script("assets/global/plugins/fullcalendar/fullcalendar.min.js")!!}
        <!-- END PAGE LEVEL PLUGINS -->
<script>
    jQuery(document).ready(function () {

        Calendar.init();
        showReport();
        UIBlockUI.init();
        ComponentsDropdowns.init();

    });


    function changeMonthYear() {
        var month = $("#monthSelect").val();
        var year = $("#yearSelect").val();
        $('#calendar').fullCalendar('gotoDate', year + '-' + month + '-01');
        showReport();

    }

    function showReport() {

        App.startPageLoading({animate: true});

        window.setTimeout(function () {
            App.stopPageLoading();
        }, 1000);

        var month = $("#monthSelect").val();
        var year = $("#yearSelect").val();
        var employeeID = $("#changeEmployee").val();

        var url = "{{ route('admin.attendance.report',':id') }}";
        url = url.replace(':id', employeeID);
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: {"month": month, "year": year, "employee_id": employeeID}

        }).done(function (response) {

            if (response.success == "success") {

                $('#attendanceReport').html(response.presentByWorking);
                $('#attendancePerReport').html(response.attendancePerReport);

            }
        });
    }
    //Function to redirect to the employees page
    function redirect_to() {

        var employee = $('#changeEmployee').val();
        var url = "{{ route('admin.attendances.show',':id') }}";
        url = url.replace(':id', employee);
        loadView(url);

    }


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
                        right: 'prev,next,today,month'
                    };
                }


                $('#calendar').fullCalendar('destroy'); // destroy the calendar
                $('#calendar').fullCalendar({ //re-initialize the calendar
                    lang: '{{Lang::getLocale()}}',
                    header: h,
                    defaultView: 'month',
                    eventRender: function (event, element) {
                        if (event.className == "holiday") {
                            var dataToFind = moment(event.start).format('YYYY-MM-DD');
                            $('.fc-day[data-date="' + dataToFind + '"]').css('background', 'rgba(255, 224, 205, 1)');
                        }
                    },
                    events: [

                        {{-- Attendance on calendar --}}

                            @foreach($attendance as $attend)
                            {
                                title: "{{$attend->status}}",
                                start: '{{$attend->date}}',
                                backgroundColor: App.getBrandColor(@if($attend->status=='present')'yellow'@else'red'@endif)

                            },
                            @endforeach


                            {{--Holidays on Calendar--}}
                            @foreach($holidays as $holiday)
                            {
                                title: "{!! $holiday->occassion !!}",
                                start: '{{$holiday->date}}',
                                backgroundColor: App.getBrandColor('grey')
                            },
                            @endforeach
                        ]
                });

            }

        };

    }();
    $.fn.select2.defaults.set("theme", "bootstrap");
    $('.select2me').select2({
        placeholder: "Select",
        width: '100%',
        allowClear: false
    });


    {{--INLCUDE ERROR MESSAGE BOX--}}

    {{--END ERROR MESSAGE BOX--}}
</script>
@stop
