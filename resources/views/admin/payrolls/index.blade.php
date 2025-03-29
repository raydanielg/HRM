@extends('admin.adminlayouts.adminlayout')

@section('head')


    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") !!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.payroll.indexTitle")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("pages.payroll.indexTitle")</span>
            </li>

        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->

    <div class="row">
        <div class="col-md-12">


            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div id="load">

                {{--INLCUDE ERROR MESSAGE BOX--}}

                {{--END ERROR MESSAGE BOX--}}

            </div>
            <div class="portlet light bordered">

                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row ">
                            <div class="col-md-3">
                                <a class="btn green" onclick="loadView('{{ route('admin.payrolls.create') }}')">
                                    {{trans('core.btnAddPayroll')}}
                                    <i class="fa fa-plus"></i> </a>
                            </div>

                            <div class="col-md-3">
                                <select class="form-control select2me" name="employee_id" id="employeeID">
                                    <option value="all">Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->full_name}} (EmpId: {{ $employee->employeeID }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <a href="" class="btn blue-chambray"
                                   onclick="showReportModal();return false;">@lang("core.monthlyExcelReport") <i
                                            class="fa fa-download"></i> </a>
                            </div>
                            <div class="col-md-3 text-right">

                                <span id="load_notification"></span>
                                <input type="checkbox"
                                       onchange="ToggleEmailNotification('payroll_notification');return false;"
                                       class="make-switch" name="payroll_notification"
                                       @if($loggedAdmin->company->payroll_notification==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                                <strong>{{trans('core.emailNotification')}}</strong><br>


                            </div>
                        </div>
                    </div>


                    <table class="table table-striped table-bordered table-hover" id="payroll">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> {{trans('core.employeeID')}} </th>
                            <th> {{trans('core.name')}} </th>
                            <th> {{trans('core.month')}} - {{trans('core.year')}} </th>
                            <th> @lang("core.netSalary") ({{$loggedAdmin->company->currency_symbol}})</th>
                            <th> {{trans('core.createdOn')}} </th>
                            <th> {{trans('core.status')}} </th>
                            <th class="text-center" width="36%"> {{trans('core.action')}} </th>
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

    {{--Select Year and month modal--}}

    <div id="reportModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">@lang("core.selectMonthAndYear")</h4>
                </div>
                {!!  Form::open(array('route'=>'admin.payroll_report','class'=>'form-horizontal','method'=>'POST','id'=>'salary-form')) !!}
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-md-9">
                                    <select class="form-control" name="month" id="month">
                                        <option value="1"
                                                @if (1 == date("n")) selected="selected"@endif>{{trans('core.January')}}</option>
                                        <option value="2"
                                                @if (2 == date("n")) selected="selected"@endif>{{trans('core.February')}}</option>
                                        <option value="3"
                                                @if (3 == date("n")) selected="selected"@endif>{{trans('core.March')}}</option>
                                        <option value="4"
                                                @if (4 == date("n")) selected="selected"@endif>{{trans('core.April')}}</option>
                                        <option value="5"
                                                @if (5 == date("n")) selected="selected"@endif>{{trans('core.May')}}</option>
                                        <option value="6"
                                                @if (6== date("n")) selected="selected"@endif >{{trans('core.june')}}</option>
                                        <option value="7"
                                                @if (7 == date("n")) selected="selected"@endif>{{trans('core.July')}}</option>
                                        <option value="8"
                                                @if (8 == date("n")) selected="selected"@endif>{{trans('core.August')}}</option>
                                        <option value="9"
                                                @if (9 == date("n")) selected="selected"@endif>{{trans('core.September')}}</option>
                                        <option value="10"
                                                @if (10 == date("n")) selected="selected"@endif>{{trans('core.October')}}</option>
                                        <option value="11"
                                                @if (11 == date("n")) selected="selected"@endif>{{trans('core.November')}}</option>
                                        <option value="12"
                                                @if (12 == date("n")) selected="selected"@endif>{{trans('core.December')}}</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-md-9">
                                    {!! Form::selectYear('year', 2013, date('Y')+1,date('Y'),['class' => 'form-control','id'=>'year'])  !!}
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>
                    <button type="submit" class="btn blue-chambray" id="report"><i
                                class="fa fa-download"></i> @lang("core.download")</button>
                </div>
                {!!  Form::close()  !!}
            </div>
        </div>
    </div>


    {{--Select Year and month modal--}}
@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {{--	{!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/jquery.dataTables.columnFilter.js")!!}--}}

    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        $(function (e) {
           loadTable();

           $('#employeeID').on('change', function() {
               loadTable();
           })

        });

        $.fn.select2.defaults.set("theme", "bootstrap");
        $('.select2me').select2({
            placeholder: "Select",
            width: '100%',
            allowClear: false
        });



        function loadTable() {
            var employee_id = $('#employeeID').val();

            var table = $('#payroll').dataTable({
                {!! $datatabble_lang !!}
                processing: true,
                serverSide: true,
                destroy: true,
                "ajax": "{!!  route('admin.ajax_payrolls')  !!}?employee_id=" + employee_id,
                "autoWidth": false,
                "aaSorting": [[6, "desc"]],
                "columns": [
                    {data: 'id', name: 'payrolls.id', 'sortable': false},
                    {data: 'employeeID', name: 'employees.employeeID', searchable: false},
                    {data: 'full_name', name: 'full_name', searchable: true},
                    {data: 'year', name: 'year', searchable: true},
                    {data: 'net_salary', name: 'net_salary', searchable: false},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions', sortable: false, searchable: false}
                ],
                "lengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                "sPaginationType": "full_numbers"

            });
        }

        function showReportModal() {
            $('#reportModal').appendTo("body").modal('show');
        }


        function del(id, title) {

            $('#deleteModal').modal('show');
            $("#deleteModal").find('#info').html('@lang("messages.payrollDeleteConfirm")');

            $('#deleteModal').find("#delete").off().click(function () {

                var url = "{{ route('admin.payrolls.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'DELETE',
                    url: url,
                    data: {'_token': token},
                    container: "#deleteModal",
                    success: function (response) {
                        if (response.status === "success") {
                            $('#deleteModal').modal('hide');
                            table.fnDraw();
                        }
                    }
                });

            });


        }
    </script>
@stop
