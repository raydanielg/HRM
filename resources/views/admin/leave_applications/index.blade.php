@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") !!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang('pages.leaveApplications.indexTitle')
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">@lang('core.dashboard')</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang('pages.leaveApplications.indexTitle')</span>
            </li>

        </ul>

    </div>            <!-- END PAGE HEADER-->            <!-- BEGIN PAGE CONTENT-->


    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div id="load">


            </div>
            <div class="portlet light bordered">

                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6 form-group text-right">
                                <span id="load_notification"></span>
                                <input type="checkbox"
                                       onchange="ToggleEmailNotification('leave_notification');return false;"
                                       class="make-switch" name="leave_notification"
                                       @if($loggedAdmin->company->leave_notification==1)checked @endif data-on-color="success"
                                       data-on-text="@lang('core.btnYes')" data-off-text="@lang('core.btnNo')"
                                       data-off-color="danger">
                                <strong>@lang('core.emailNotification')</strong><br>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover" id="applications">
                        <thead>
                        <tr>
                            <th>@lang('core.id')</th>
                            <th>@lang('core.name')</th>
                            <th>@lang('core.dates')</th>
                            <th>@lang('core.days')</th>
                            <th>@lang('core.leaveTypes')</th>

                            <th>@lang('core.reason')</th>
                            <th>@lang('core.appliedOn')</th>
                            <th>@lang('core.status')</th>
                            <th>@lang('core.actions')</th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->

        </div>
    </div>            <!-- END PAGE CONTENT-->


    {{--Reject--}}

    {{--MODAL CALLING--}}
    @include('admin.common.delete')
    @include('admin.common.show-modal')
    {{--MODAL CALLING END--}}

@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/admin/pages/scripts/table-managed.js")!!}
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->


    <script>
        var table = $('#applications').dataTable({
            processing: true,
            serverSide: true,
            "aaSorting": [[0, "desc"]],
            {!! $datatabble_lang !!}
            "ajax": "{{ URL::route('admin.leave_applications') }}",
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'full_name'},
                {data: 'start_date', name: 'start_date'},
                {data: 'days', name: 'days'},
                {data: 'leaveType', name: 'leaveType'},
                {data: 'reason', name: 'reason'},
                {data: 'applied_on', name: 'applied_on'},
                {data: 'application_status', name: 'application_status'},
                {data: 'edit', name: 'edit'},
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            }

        });


        function del(id) {

            $('#deleteModal').modal('show');

            $("#deleteModal").find('#info').html("@lang("messages.leaveApplicationDeleteConfirm")");
            $('#deleteModal').find("#delete").off().click(function () {
                var url = "{{ route('admin.leave_applications.destroy',':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: 'json',
                    data: {"id": id}
                }).done(function (response) {
                    if (response.success == "deleted") {

                        $('#deleteModal').modal('hide');
                        $('#row' + id).fadeOut(500);
                        table._fnDraw();
                        showToastrMessage("@lang("messages.leaveApplicationDeleteMessage")", '{{__('core.success')}}', 'success');
                    }
                });
            })
        }

        function show_application(id) {
            var url = "{!!  route('admin.leave_applications.show',':id')  !!}";
            url = url.replace(':id', id);
            $.ajaxModal('#showModal', url);
        }



    </script>

@stop
