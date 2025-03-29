@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!!  HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!!  HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    {!!  HTML::style("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.css")!!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


    <div class="page-head">
        <div class="page-title"><h1>
                {{ trans('pages.employees.indexTitle') }}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.dashboard') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">{{ trans('pages.employees.indexTitle') }}</span>

            </li>

        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div class="portlet light bordered">

                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="btn-group">
                                    {{--@if($canCreateEmployee)--}}
                                        <a href="javascript: ;" onclick="addEmployee()" class="btn green">
                                            <span class="hidden-xs"> {{ trans('core.btnAddEmployee') }} </span><i
                                                    class="fa fa-plus"></i>
                                        </a>
                                    {{--@endif--}}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="pull-right">
                                    <a href="{{route('admin.employees.export') }}" class="btn red">
                                        <i class="fa fa-file-excel-o"></i> <span
                                                class="hidden-xs">{{ trans('core.export') }}</span>
                                    </a>
                                    {{--<a href="javascript:;" onclick="loadView('{{route('admin.employees.import') }}')--}}
                                    {{--" class="btn blue">--}}
                                    {{--<i class="fa fa-upload"></i> <span--}}
                                    {{--class="hidden-xs">{{ trans('core.importEmployees') }}</span>--}}
                                    {{--</a>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover responsive hidden"
                           id="sample_employees">
                        <thead>
                        <tr>
                            <th class="text-center all">
                                {{ trans('core.employeeID') }}
                            </th>
                            <th class="text-center min-tablet">
                                {{ trans('core.image') }}
                            </th>
                            <th style="text-align: center" class="all">
                                {{ trans('core.name') }}
                            </th>
                            <th class="text-center min-desktop">
                                {{ trans('core.department') }}
                            </th>
                            <th class="text-center min-desktop">
                                {{ trans('core.designation') }}
                            </th>
                            <th class="text-center min-desktop">
                                {{ trans('core.atWork') }}
                            </th>

                            <th class="text-center min-desktop">
                                {{ trans('core.status') }}
                            </th>
                            <th class="never">Created AT</th>
                            <th class="text-center min-tablet">
                                {{ trans('core.actions') }}
                            </th>
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

    <div id="empAddWarningModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{trans('core.confirmation')}}</h4>
                </div>
                <div class="modal-body" id="addEmployeeInfo">
                    <p>
                        {{ trans('messages.addNewEmployeeWarning') }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>
                    <a href="javascript: ;" onclick="confirmAddEmployee()" class="btn green">
                        <span class="hidden-xs"> {{ trans('core.btnConfirm') }} </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@stop


@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!!  HTML::script("assets/global/plugins/select2/js/select2.min.js") !!}
    {!!  HTML::script("assets/global/plugins/datatables/datatables.min.js") !!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") !!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/responsive/dataTables.responsive.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.js")!!}

    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        var total = "{{ $total }}";
        // begin first table
        var table = $('#sample_employees').dataTable({
            {!! $datatabble_lang !!}
            processing: true,
            serverSide: true,
            "ajax": "{{ route("admin.ajax_employees") }}",
            "autoWidth": false,
            "aaSorting": [[7, "desc"]],
            columns: [
                {data: 'employeeID', name: 'employeeID', "bSortable": true, width: "80px"},
                {data: 'profile_image', name: 'profile_image', "bSortable": false, "searchable": false},
                {data: 'full_name', name: 'full_name', "bSortable": true},
                {data: 'name', name: 'name', "bSortable": true},
                {data: 'designation', name: 'designation', "bSortable": true},
                {data: 'work', name: 'work', "bSortable": false},
                {data: 'status', name: 'status', "bSortable": true},
                {data: 'created_at', name: 'created_at', "bSortable": false, width: "150px"},
                {data: 'edit', name: 'edit', "bSortable": false},
            ],

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "sPaginationType": "full_numbers",
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {  // set default column settings
                'targets': [7],
                "visible": false,
                "searchable": false
            }
            ],
            "fnInitComplete": function () {
                $(".dataTables_length").addClass("hidden-xs");
                $(this).removeClass("hidden");
            },
            "order": [
                [7, "DESC"]
            ]
        });


        function del(id, name) {

            $('#deleteModal').modal('show');

            var confirmMsg = '{!! trans('messages.deleteConfirm', ["name" => ":name"]) !!}';
            confirmMsg = confirmMsg.replace(":name", name);

            $("#deleteModal").find('#info').html(confirmMsg);

            $('#deleteModal').find("#delete").off().click(function () {

                var url = "{{ route('admin.employees.destroy',':id') }}";
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


        function addEmployee() {
            var planUser = '{{ admin()->company->subscriptionPlan->end_user_count }}';
            if ( parseInt(planUser) >= parseInt(total) ) {
                loadView('{{route('admin.employees.create') }}')

            } else {
                $('#empAddWarningModal').modal('show');
            }
        }

        function confirmAddEmployee() {
            $('#empAddWarningModal').modal('hide');
            loadView('{{route('admin.billing.change_plan') }}');
        }

    </script>
@stop
