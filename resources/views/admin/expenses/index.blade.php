@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.expenses.indexTitle")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("pages.expenses.indexTitle")</span>
            </li>

        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a onclick="loadView('{{ route('admin.expenses.create')}}')" class="btn green">
                                        {{trans('core.btnAddExpense')}} {{trans('core.item')}} <i
                                                class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group pull-right">
                                    <span id="load_notification"></span>
                                    <input type="checkbox"
                                           onchange="ToggleEmailNotification('expense_notification');return false;"
                                           class="make-switch" name="expense_notification"
                                           @if($loggedAdmin->company->expense_notification==1)checked
                                           @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                           data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                                    <strong>{{trans('core.emailNotification')}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover" id="expenses">
                        <thead>
                        <tr>
                            <th> @lang("core.serialNo")</th>
                            <th> {{trans('core.item')}} </th>
                            <th> {{trans('core.purchase_from')}} </th>
                            <th> {{trans('core.date')}} </th>
                            <th> {{trans('core.employee')}} </th>
                            <th> {{trans('core.price')}} ({{$loggedAdmin->company->currency_symbol}})</th>
                            <th> {{trans('core.status')}} </th>
                            <th>Hidden ID</th>
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
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {{--    	{!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/jquery.dataTables.columnFilter.js")!!}--}}

    <!-- END PAGE LEVEL PLUGINS -->

    <script>


        var table = $('#expenses').dataTable({
            processing: true,
            serverSide: true,
            {!! $datatabble_lang !!}
            "ajax": "{!!  route('admin.ajax_expenses')  !!}",
            columns: [
                {data: 's_id', name: 's_id'},
                {data: 'item_name', name: 'item_name'},
                {data: 'purchase_from', name: 'purchase_from'},
                {data: 'purchase_date', name: 'purchase_date'},
                {data: 'full_name', name: 'full_name'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'},
                {data: 'id', name: 'id'},
                {data: 'edit', name: 'edit'}
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "columnDefs": [{  // set default column settings
                "visible": false,
                "searchable": false,
                'targets': [7]
            }],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "fnInitComplete": function (oSettings, json) {
            }

        });

        // Show Delete Modal
        function del(id, name) {

            $('#deleteModal').modal('show');

            $("#deleteModal").find('#info').html('Are you sure ! You want to delete <strong>' + name + '?');

            $('#deleteModal').find("#delete").off().click(function () {

                var url = "{{ route('admin.expenses.destroy',':id') }}";
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


        function changeStatus(id, status) {

            var url = "{{ route('admin.expense.change_status',':id') }}";
            url = url.replace(':id', id);

            $.easyAjax({
                type: 'POST',
                url: url,
                data: {status: status},
                container: "#deleteModal",
                success: function (response) {
                    if (response.status === "success") {
                        table.fnDraw();
                    }
                }
            });

        }
    </script>
@stop
