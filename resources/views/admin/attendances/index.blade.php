@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css") !!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    <!-- END PAGE LEVEL STYLES -->
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
                <a onclick="loadView('{{ route('admin.attendance.employee') }}')" class="btn {{ isset($viewAttendanceEmployeeActive) ? $viewAttendanceEmployeeActive : ''}}">
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
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div id="load">

                @if(Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

            </div>

            <div class="portlet light bordered">
                <div class="portlet-body">

                    <div class="table-toolbar margin-top-15">
                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::open(['route'=>["admin.attendances.create"], 'method'=>'GET', 'class' => "form-inline"]) !!}
                                <div class="btn-group">
                                    <div class="input-group input-medium date date-picker"
                                         data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                        <input type="text" class="form-control" name="date"
                                               placeholder="@lang("core.selectDate")"
                                               readonly>
                                        <span class="input-group-btn">
															   <button class="btn default" type="button"><i
                                                                           class="fa fa-calendar"></i></button>
															   </span>
                                    </div>
                                </div>
                                <button class="btn blue" type="submit">{{trans('core.btnSubmit')}}</button>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <div class="btn-group pull-right">
                                    <a href="{{route('admin.attendances.create')}}"
                                       data-loading-text="@lang("core.redirecting")..."
                                       class="btn green">
                                        {{trans('core.markToday')}} <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th> @lang("core.employeeID") </th>
                            <th class="text-center"> {{trans('core.image')}} </th>
                            <th> {{trans('core.name')}} </th>
                            <th> {{trans('core.lastAbsent')}} </th>
                            <th> {{trans('core.leaves')}} </th>
                            <th> {{trans('core.annualOrCredit')}} </th>
                            <th> {{trans('core.status')}}</th>
                            <th> {{trans('core.action')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->

        </div>
    </div>
    <!-- END PAGE CONTENT-->

    {{--MODAL CALLING--}}
    @include('admin.common.delete')
    {{--MODAL CALLING END--}}

@stop


@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/admin/pages/scripts/table-managed.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")!!}
    {!! HTML::script("assets/admin/pages/scripts/components-pickers.js")!!}

    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        jQuery(document).ready(function () {
            ComponentsPickers.init();
            // begin first table
            $('#sample_1').dataTable({
                processing: true,
                serverSide: true,
                {!! $datatabble_lang !!}
                "aaSorting": [[2, "asc"]],
                "ajax": "{{ route("admin.attendance.ajax_employees") }}",
                "columns": [
                    {data: 'employeeID', name: 'employees.employeeID', searchable: true},
                    {data: 'profile_image', name: 'employees.profile_image', searchable: false},
                    {data: 'full_name', name: 'employees.full_name'},
                    {data: 'last_absent', name: 'last_absent', searchable: false},
                    {data: 'leave_types', name: 'leaves', searchable: false},
                    {data: 'annual_leave', name: 'annual_leave'},
                    {data: 'status', name: 'employees.status'},
                    {data: 'edit', name: 'edit'}
                ],
                "lengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 5,
                "sPaginationType": "full_numbers",
                "order": [
                    [2, "asc"]
                ] // set first column as a default sort by asc
            });

        });
    </script>

@stop
