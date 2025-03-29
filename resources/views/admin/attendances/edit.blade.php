@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style('assets/global/plugins/uniform/css/uniform.default.min.css')!!}
    {!! HTML::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-form-editable/bootstrap3-editable/css/bootstrap-editable.css")!!}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{trans('pages.attendances.createTitle')}}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.attendances.index') }}')">{{trans('pages.attendances.indexTitle')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">{{trans('pages.attendances.createTitle')}}</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    @if (count($leaveTypes) == 0)
                        <div class="note note-warning">
                            <h4 class="block">{{ trans("core.leaveTypesMissing") }}</h4>
                            <p>
                                {!! trans("messages.addLeaveTypes") !!}
                            </p>
                        </div>
                    @elseif($loggedAdmin->company->attendance_setting_set == 0)
                        <div class="note note-warning">
                            <h4 class="block">{{ trans("core.setAttendanceSettings") }}</h4>
                            <p>
                                {!! trans("messages.attendanceSettings") !!}
                            </p>
                        </div>
                    @else
                        <div class="table-toolbar margin-top-15">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::open(['route'=>["admin.attendances.create"], 'method' => 'GET', 'class' => "form-inline", 'id' => "new_date"]) !!}
                                    <div class="btn-group">
                                        <div class="input-group input-medium date date-picker "
                                             data-date-viewmode="years" id="date_change">
                                            <input type="text" class="form-control " name="date"
                                                   placeholder="@lang("core.selectDate")"
                                                   readonly id="attendence_date" value="{{ $date->format('d-m-Y') }}">
                                            <span class="input-group-btn">
															   <button class="btn default" type="button"><i
                                                                           class="fa fa-calendar"></i></button>
															   </span>
                                        </div>
                                    </div>
                                    {{--<button class="btn blue" type="submit">{{trans('core.btnSubmit')}}</button>--}}
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-md-4 text-center">
                                    @if(!$date->isToday())
                                        <a href="javascript:;"
                                           onclick="loadView('{{ route('admin.attendances.create') }}');"
                                           data-loading-text="@lang("core.redirecting")..." class="btn green">
                                            {{trans('core.markToday')}} <i class="fa fa-plus"></i>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="btn-group pull-right">
                                        @if ($employees_count > \App\Http\Controllers\Admin\EmployeesController::$MAX_EMPLOYEES)
                                            {!! help_text('emailNotificationDisabled', 'left') !!}
                                        @else
                                            <span id="load_notification"></span>
                                            <input type="checkbox"
                                                   onchange="ToggleEmailNotification('attendance_notification');return false;"
                                                   class="make-switch" name="attendance_notification"
                                                   @if($loggedAdmin->company->attendance_notification==1)checked
                                                   @endif data-on-color="success"
                                                   data-on-text="{{trans('core.btnYes')}}"
                                                   data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                                            <strong>{{trans('core.emailNotification')}}</strong>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($todays_holidays->date))
                            <div class="note note-warning">
                                <h3>{!! \Carbon\Carbon::parse($todays_holidays->date)->timezone($timeZoneLocal)->format("l, jS M Y") !!}</h3>
                                <h4>{!! trans("messages.todayIsHoliday", ["date" => $todays_holidays->occassion]) !!}</h4>
                            </div>
                        @endif

                        @if(count($attendance)==0)
                            <div class="note note-warning">
                                <h4 class="block">{{ trans("core.employeesMissing") }}</h4>
                                <p>{{ trans("core.addSomeEmployees") }}</p>
                            </div>
                        @else
                            {!! Form::open(['route' => ["admin.attendances.update", $date->format("Y-m-d")], 'class'=>'form-horizontal ajax_form', 'method'=>'PATCH']) !!}
                            <div id="alert_box"></div>
                            <h4 class="form-section text-center"
                                style="font-weight: bold;">@lang("core.date"): <span
                                        id="date_heading">{{ $date->format("d-M-Y") }} @if($date->isToday())
                                        (Today)@endif</span></h4>

                            <table class="table table-striped table-bordered table-hover order-column hidden"
                                   id="attendanceTable">
                                <thead>
                                <tr>
                                    {{--												   <th>@lang("core.employeeID")</th>--}}
                                    <th>@lang("core.name")</th>
                                    <th>@lang("core.status")</th>
                                    <th>@lang("core.attendance")</th>
                                    <th>Clock-In/Out Time</th>
                                    <th>Save</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <input type="hidden" id="attendanceDetails"
                                               name="attendanceDetails[]">
                                        <button type="button" id="update_attendence" class="btn green"
                                                onclick="ajaxUpdateAttendance()"><i
                                                    class="fa fa-check"></i> {{trans('core.btnSaveAll')}}
                                        </button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            {!!   Form::close()  !!}
                        @endif
                    @endif
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>

@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')!!}
    {!! HTML::script("assets/global/plugins/moment.min.js") !!}
    {!! HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/responsive/dataTables.responsive.min.js")!!}
    {!! HTML::script("assets/admin/pages/scripts/components-pickers.js")!!}
    {!! HTML::script('assets/js/ajaxform/jquery.form.min.js')!!}
    {!! HTML::script('assets/js/commonjs.js')!!}
    {!! HTML::script('assets/global/plugins/bootstrap-form-editable/bootstrap3-editable/js/bootstrap-editable.min.js')!!}



    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        var attendanceData = {};
        var employeeIDs = [];

        jQuery(document).ready(function () {
            //ComponentsPickers.init();
            loadDataTable();
        });

    </script>

    <script>
        $('.timepicker').timepicker({
            autoclose: true,
            minuteStep: 5,
            disableMousewheel: true,
            disableFocus: true
        });

        var bindDatePicker = function (element) {
            $(element).timepicker({
                autoclose: true,
                minuteStep: 5,
                disableMousewheel: true,
                disableFocus: true
            });
        };

        var table;

        function loadDataTable() {
            table = $('#attendanceTable').dataTable({

                "bProcessing": false,
                "bServerSide": true,
                "ajax": {
                    "url": "{{ URL::route("admin.attendance.ajax_attendance") }}",
                    "data": function (d) {
                        d.date = $('#attendence_date').val();
                    }
                },
                "aaSorting": [[0, "desc"]],
                "autoWidth": false,

                columns: [
                    {data: 'eID', name: 'eID', sWidth: "20%"},
                    {data: 'status', name: 'status', sWidth: "30%"},
                    {data: 'date', name: 'date', sWidth: "20%"},
                    {data: 'clock_in', name: 'clock_in', sWidth: "25%"},
                    {data: 'action', name: 'action', sWidth: "5%"},
                ],
                "lengthMenu": [
                    [-1],
                    ["All"] // change per page values here
                ],
                iDisplayLength: -1,
                sPaginationType: "full_numbers",
                fnCreatedRow: function (nRow, aData, iDisplayIndex) {
                    var bs = $(nRow).find(".make-bs-switch");

                    if (!bs.data("bootstrap-switch")) {
                        bs.bootstrapSwitch();
                    }

                    var timepicker = $(nRow).find('.timepicker');
                    bindDatePicker(timepicker);
                    $(nRow).find('.late_checkbox').uniform('refresh');
                    $(nRow).find('.half-day-checkbox').uniform('refresh');
                    $(nRow).find('.form-edit').editable({
                        url: ''
                    });

                    $(nRow).find("input").on("change switchChange.bootstrapSwitch", function () {
                        var employeeID = $(nRow).find("input[name='employees[]']").val();
                        var obj = {
                            employeeID: employeeID,
                            status: $(nRow).find(".make-bs-switch").bootstrapSwitch('state'),
                            leaveType: $(nRow).find(".leaveType").val(),
                            halfDay: $(nRow).find(".half-day-checkbox").prop("checked"),
                            reason: $(nRow).find(".reason").val(),
                            clock_in: $(nRow).find(".clockin").val(),
                            clock_out: $(nRow).find(".clockout").val(),
                            late: $(nRow).find(".late_checkbox").prop("checked")
                        };
                        attendanceData[employeeID] = obj;
                    });

                },
                "fnInitComplete": function () {
                    $(".dataTables_info").addClass("hidden");
                    $(".dataTable").removeClass("hidden");
                },
                scrollY: "400px",
                scroller: {
                    loadingIndicator: true,
                    boundaryScale: 0.25
                },
                deferRender: true
//		 bInfo : false

            });

        }

        function showHide(id) {
            if ($('#checkbox' + id + ':checked').val() == 'on') {
                $('#leaveForm' + id).addClass("hidden");
            } else {
                $('#leaveForm' + id).removeClass("hidden");

                var leaveType = $('#leaveType' + id).val();
                if (leaveType == 'half day') {
                    $('#halfLeaveType' + id).show();
                }
            }
        }

        function halfDayToggle(id, value) {

            if (value == 'half day') {
//			 $('#halfDayLabel').show(100);
                $('#halfLeaveType' + id).show(100);
            } else {
                $('#halfLeaveType' + id).hide(100);
            }

        }

        $('#date_change').datepicker({
            format: "dd-mm-yyyy",
            todayHighlight: true,
            toggleActive: true,
            autoclose: true
        }).on('changeDate', function (e) {
            var url = "{{ route("admin.attendances.edit", "#id") }}";
            var date = moment($('#attendence_date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
            url = url.replace("#id", date);
            loadView(url);
        });

        function ajaxUpdateAttendance() {

            var data = JSON.stringify(attendanceData);

            var date = $('#attendence_date').val();
            var url = "{{ route("admin.attendances.update", "#id") }}";
            url = url.replace("#id", date);

            $.ajax({
                url: url,
                dataType: 'json',
                data: {data: data, _method: "PATCH", _token: "{{ csrf_token() }}"},
                method: 'POST',
                beforeSend: function () {
                    $('#update_attendence').attr("disabled", true);
                },
                success: function (response) {
                    $('#update_attendence').attr("disabled", false);
                    showResponseMessage(response, 'error');
                    var route = "{{ route("admin.attendances.edit", ["attendances" => "#id"]) }}";
                    var date = moment(response.date);

                    var url = route.replace("#id", date.format("YYYY-MM-DD"));
                    loadView(url);
                },
                error: function (xhr, textStatus, thrownError) {
                    resposeArray = {
                        "status": "fail",
                        "errorCode": "unkonwn",
                        "message": "Problem logging in, please try again!"
                    };
                    showResponseMessage(resposeArray, "error");
                }
            });
            return false;
        }

        function attendanceRow(id) {

            loadingButton("#update_row" + id);
            var status = null;
            var leave_type = null;
            var half_day = null;
            var reason = null;
            var clock_in_ip = $('#clock_in_ip' + id).html();
            var clock_out_ip = $('#clock_out_ip' + id).html();
            var work = $('#work' + id).html();
            var notes = $('#notes' + id).html();
            var attendance_date = $('#attendence_date').val();
            var is_late = $("#late" + id).is(":checked");

            if ($('#checkbox' + id).is(":checked") == true) {
                status = "present";
            } else {
                status = "absent";
                leave_type = $('#leaveType' + id).val();
                half_day = $('#halfDay' + id).is(':checked');
                reason = $('#reason' + id).val();
            }

            var clock_in = $('#clock_in' + id).val();
            var clock_out = $('#clock_out' + id).val();

            $.ajax({
                type: "POST",
                url: "{!! route('admin.attendance.update.row') !!}",
                data: {
                    "id": id,
                    "status": status,
                    "leave_type": leave_type,
                    "half_day": half_day,
                    "reason": reason,
                    "clock_in": clock_in,
                    "clock_out": clock_out,
                    "date": attendance_date,
                    "clock_in_ip": clock_in_ip,
                    "clock_out_ip": clock_out_ip,
                    "work": work,
                    "notes": notes,
                    "is_late": is_late
                }
            }).done(function (response) {
                unloadingButton("#update_row" + id);
                showResponseMessage(response, 'error');
                var late_badge = '';
                if (response.checkbox == "1") {
                    $("#uniform-late" + id + " span").addClass("checked");
                    late_badge = '<span class="label label-danger">Late</span>';
                } else {
                    $("#uniform-late" + id + " span").removeClass("checked");
                }

                $("#updateCell" + id).parent("td").html(response.divHTML);

                $('.form-edit').editable({
                    url: ''
                });

            }).fail(function (response) {
                unloadingButton("#update_row" + id);
                showToastrMessage("@lang("messages.generalError")", "@lang("core.error")", "error");
            });
        }
    </script>
@stop
