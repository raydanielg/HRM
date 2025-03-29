@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.css")!!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{ trans("pages.awards.indexTitle") }}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">{{ trans("pages.awards.indexTitle") }}</span>
            </li>

        </ul>

    </div>            <!-- END PAGE HEADER-->            <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div class="portlet light bordered">

                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <div class="btn-group">
                                    <a class="btn green" data-toggle="modal"
                                       onclick="loadView('{{route('admin.awards.create')}}')">
                                        <span class="hidden-xs">{{trans('core.btnAddAward')}}</span>
                                        <i class="fa fa-plus"></i> </a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="btn-group pull-right">
                                    <span id="load_notification" class="hidden-xs"></span>
                                    <input type="checkbox"
                                           onchange="ToggleEmailNotification('award_notification');return false;"
                                           class="make-switch" name="award_notification"
                                           @if($loggedAdmin->company->award_notification==1)checked
                                           @endif data-on-color="success"
                                           data-on-text="<i class='fa fa-bell-o'></i>"
                                           data-off-text="<i class='fa fa-bell-slash-o'></i>"
                                           data-off-color="danger">
                                    <span class="hidden-xs"><strong>{{trans('core.emailNotification')}}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover responsive hidden" id="awards">
                        <thead>
                        <tr>
                            <th class="never">{{-- Hidden ID --}}</th>
                            <th class="min-tablet"> {{trans('core.employeeID')}} </th>
                            <th class="all"> {{trans('core.awardeeName')}} </th>
                            <th class="min-desktop"> {{trans('core.award')}} </th>
                            <th class="min-desktop"> {{trans('core.gift')}} </th>
                            <th class="never">{{-- Hidden Month --}}</th>
                            <th class="never">Created At</th>
                            <th class="all"> {{trans('core.month')}}</th>
                            <th class="min-tablet"> {{trans('core.actions')}} </th>
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
    {!! HTML::script("assets/global/plugins/datatables/plugins/responsive/dataTables.responsive.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.js")!!}

    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        var table = $('#awards').dataTable({
            {!! $datatabble_lang !!}
            processing: true,
            serverSide: true,
            "ajax": "{{ route("admin.ajax_awards") }}",
            "aaSorting": [[6, "asc"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'employee_id', name: 'employee_id'},
                {data: 'full_name', name: 'full_name', "searchable": false},
                {data: 'award_name', name: 'award_name'},
                {data: 'gift', name: 'gift'},
                {data: 'month', name: 'month'},
                {data: 'created_at', name: 'created_at'},
                {data: 'For Month', name: 'For Month'},
                {data: 'edit', name: 'edit'},
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }, {
                    "targets": [5],
                    "visible": false,
                    "searchable": true
                }, {
                    "targets": [6],
                    "visible": false,
                    "searchable": true
                }

            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnInitComplete": function () {
                $(".dataTables_length").addClass("hidden-xs");
                $(this).removeClass("hidden");
            },

            fnRowCallback: function (nRow, aData, iDisplayIndex) {
                var row = $(nRow);
                row.attr("id", 'row' + aData['0']);
            },

            fnDrawCallback: function () {
            },
            "order": [
                [6, "ASC"]
            ]


        });


        // Show Delete Modal
        function del(id, award) {

            $('#deleteModal').modal('show');

            $("#deleteModal").find('#info').html('Are you sure ! You want to delete <strong>' + award + '?');

            $('#deleteModal').find("#delete").off().click(function () {

                var url = "{{ route('admin.awards.destroy',':id') }}";
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
