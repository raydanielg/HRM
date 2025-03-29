@extends('admin.adminlayouts.adminlayout')

@section('head')


    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")!!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.jobApplications.indexTitle")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{__('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("pages.jobApplications.indexTitle")</span>
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


                    <table class="table table-striped table-bordered table-hover" id="jobs">
                        <thead>
                        <tr>
                            <th> @lang("core.serialNo")</th>
                            <th> {{trans('core.position')}} </th>

                            <th> {{trans('core.name')}} </th>
                            <th> {{trans('core.email')}} </th>
                            <th> {{trans('core.phone')}} </th>
                            <th> {{trans('core.appliedOn')}} </th>
                            <th> {{trans('core.submittedBy')}} </th>
                            <th> {{trans('core.status')}} </th>
                            <th> {{trans('core.action')}} </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->

        </div>
    </div>
    <!-- END PAGE CONTENT-->
    @include('admin.common.delete')
    @include('admin.common.show-modal')
@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js")!!}


    <!-- END PAGE LEVEL PLUGINS -->

    <script>

        var table = $('#jobs').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ URL::route("admin.ajax_jobs_applications") }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'position', name: 'position'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'created_at', name: 'created_at'},
                {data: 'full_name', name: 'full_name'},
                {data: 'status', name: 'status'},
                {data: 'edit', name: 'edit'},
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                App.init();
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;

            },
            "language": {},
            "fnInitComplete": function (oSettings, json) {
                App.init();
            }
        });


        function del(id) {

            $('#deleteModal').modal('show');
            $("#deleteModal").find('#info').html('@lang("messages.jobApplicationsDeleteConfirm")');

            $('#deleteModal').find("#delete").off().click(function () {

                var url = "{{ route('admin.job_applications.destroy',':id') }}";
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


            $.easyAjax({
                type: 'POST',
                url: "{{route('admin.job_applications.change_status')}}",
                container: '.page-content',
                data: {'status': status, 'id': id},
                success: function (response) {
                    if (response.status === "success") {
                        table.fnDraw();
                    }
                }
            });
        }

        function showView(id) {
            var get_url = "{{ route('admin.job_applications.show',':id') }}";
            get_url = get_url.replace(':id', id);
            $.ajaxModal('#showModal', get_url);
        }

        function addUpdateLeaveType(id) {

            if (typeof id != 'undefined') {
                var url = "{{ route('admin.leavetypes.update',':id') }}";
                url = url.replace(':id', id);
            } else {
                url = "{{route('admin.leavetypes.store')}}";
            }
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '#leave_type_update_form',
                data: $('#leave_type_update_form').serialize(),
                success: function (response) {
                    if (response.status == "success") {
                        $('#showModal').modal('hide');
                        table.fnDraw();
                    }

                }
            });
        }


    </script>
@stop
