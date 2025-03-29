@extends('admin.adminlayouts.adminlayout')
@section('head')
    <style>
        .btn.active {
            opacity: 2 !important;
        }
    </style>
@stop

@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.attendances.indexTitle")
            </h1></div>
        <div class="page-toolbar">
            <!-- BEGIN THEME PANEL -->
            <div class="btn-theme-panel">
                <a onclick="loadView('{{ route('admin.attendances.index') }}')" class="btn {{ isset($viewAttendanceActive) ? $viewAttendanceActive : ''}}">
                    <i class="fa fa-th"></i>
                </a>
                <a onclick="loadView('{{ route('admin.attendance.employee') }}')" class="btn">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <!-- END THEME PANEL -->
        </div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("pages.attendances.indexTitle")</span>
            </li>

        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->

    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="row filter-row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group form-focus">
                                <label class="control-label">Employee Name</label>
                                <select class="form-control select2me" name="employee_id">
                                    <option value="all">All</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->full_name}} (EmpId: {{ $employee->employeeID }})</option>
                                    @endforeach
                                </select>


                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group form-focus">
                                <label class="control-label">Select Month</label>
                                <select class="form-control select floating" name="month">
                                    <option value="1"
                                            @if(strtolower(date('F'))=='january')selected='selected'@endif >Jan
                                    </option>
                                    <option value="2"
                                            @if(strtolower(date('F'))=='february')selected='selected'@endif>Feb
                                    </option>
                                    <option value="3"
                                            @if(strtolower(date('F'))=='march')selected='selected'@endif>Mar
                                    </option>
                                    <option value="4"
                                            @if(strtolower(date('F'))=='april')selected='selected'@endif>Apr
                                    </option>
                                    <option value="5" @if(strtolower(date('F'))=='may')selected='selected'@endif>
                                        May
                                    </option>
                                    <option value="6"
                                            @if(strtolower(date('F'))=='june')selected='selected'@endif>Jun
                                    </option>
                                    <option value="7"
                                            @if(strtolower(date('F'))=='july')selected='selected'@endif>Jul
                                    </option>
                                    <option value="8"
                                            @if(strtolower(date('F'))=='august')selected='selected'@endif>Aug
                                    </option>
                                    <option value="9"
                                            @if(strtolower(date('F'))=='september')selected='selected'@endif>
                                        Sep
                                    </option>
                                    <option value="10"
                                            @if(strtolower(date('F'))=='october')selected='selected'@endif>Oct
                                    </option>
                                    <option value="11"
                                            @if(strtolower(date('F'))=='november')selected='selected'@endif>Nov
                                    </option>
                                    <option value="12"
                                            @if(strtolower(date('F'))=='december')selected='selected'@endif>Dec
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group form-focus">
                                <label class="control-label">Select Year</label>
                                {!!  Form::selectYear('year', 2015, date('Y'),date('Y'),['class' => 'form-control select floating'])  !!}
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group form-focus">
                                <label class="control-label">&nbsp;</label>
                                <a href="javascript:;" class="btn btn-success btn-block" onclick="filter(); return false;"> Search </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="attendance-sheet">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!!  HTML::script("assets/hr/js/select2.min.js") !!}

    <!-- END PAGE LEVEL PLUGINS -->
    <script type="text/javascript">
       var filter = () => {
            var data = {
                employee_id: $("select[name='employee_id']").val(),
                month: $("select[name='month']").val(),
                year: $("select[name='year']").val(),
                _token: '{{ csrf_token() }}'
            };

            var url = "{{ route('admin.attendance.filter') }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '#attendance-sheet',
                data: data,
                success: function (res) {
                    if (res.status === 'success') {
                        $('#attendance-sheet').html(res.data);
                    }
                }
            });
        };
       jQuery(document).ready(function () {
           filter();
       });
    </script>
@stop
