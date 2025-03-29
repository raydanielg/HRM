@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    <!-- END PAGE LEVEL STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{$pageTitle}}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">{{$pageTitle}}</a>

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
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-key font-dark"></i> License Type Default Pricing
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover" id="table">
                        <thead>
                        <tr>
                            <th> Sr No.</th>
                            <th> Name</th>
                            <th> Free Users</th>
                            <th> Price(USD)</th>
                            <th> Type</th>
                            <th> Status</th>

                            <th class="text-center"> {{trans('core.action')}} </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->

    {{--License Types--}}
    <div id="static_license" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{$pageTitle}}</h4>
                </div>
                <div class="modal-body" id="license-form-body">
                    {{--Ajax replace content--}}
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>

                </div>
            </div>
        </div>
    </div>

    {{--END License Types--}}
@stop



@section('footerjs')
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}

    <!-- END PAGE LEVEL PLUGINS -->

    <script>


        var table1 = $('#table').dataTable({
            {!! $datatabble_lang !!}
            processing: true,
            serverSide: true,
            "ajax": "{{ URL::route("admin.ajax_license_types") }}",
//            "aaSorting": [[ 1, "asc" ]],
            columns: [
                { data: 'id', name: 'id', "bSortable": true },
                { data: 'name', name: 'name', "bSortable": true },
                { data: 'free_users', name: 'free_users', "bSortable": true },
                { data: 'price', name: 'price', "bSortable": true },
                { data: 'type', name: 'type', "bSortable": true },
                { data: 'status', name: 'status', "bSortable": true },
                { data: 'edit', name: 'edit', "bSortable": false },
            ],
            "iDisplayLength": 10,
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {

            },
            "fnInitComplete": function (oSettings, json) {

                App.init();


            }

        });
        var table2 = $('#table2').dataTable({
            {!! $datatabble_lang !!}
            "bProcessing": true,

            "bServerSide": true,
            "ajax": "{{ URL::route("admin.ajax_license_types_country") }}",
//            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [

                {'sClass': 'center', "bSortable": true},
                {'sClass': 'center', "bSortable": true},
                {'sClass': 'center', "bSortable": true},
                {'sClass': 'center', "bSortable": true},
                {'sClass': 'center', "bSortable": true},
                {'sClass': 'center', "bSortable": true},
                {'sClass': 'center', "bSortable": false}
            ],
            "iDisplayLength": 10,
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {

            },
            "fnInitComplete": function (oSettings, json) {

//              App.init();


            }

        });


        function showEdit(id, table) {
            $('#static_license').modal('show');
            $("body").addClass("modal-open");
            if (table == 'country') {
                var get_url = "{{ route('admin.license_types_country.edit',':id') }}";
            } else {
                var get_url = "{{ route('admin.license_types.edit',':id') }}";
            }

            get_url = get_url.replace(':id', id);

            $("#edit-form-body").html('<div class="text-center">>{!!  HTML::image('assets/loader.gif') !!}</div>');

            $.ajax({
                type: "GET",
                url: get_url,
                data: {}
            }).done(function (response) {
                $("#license-form-body").html(response);

            });
        }

        function updateData(id, table) {
            if (table == 'country') {
                var get_url = "{{ route('admin.license_types_country.update',':id') }}";
            } else {
                var get_url = "{{ route('admin.license_types.update',':id') }}";
            }

            get_url = get_url.replace(':id', id);
            $("#error_edit").html('<div class="alert alert-info">{{trans('messages.submitting')}}..</div>');
            $("#submitbutton_edit").prop('disabled', true);

            $.ajax({
                type: 'PUT',
                url: get_url,
                dataType: "JSON",
                data: $('#edit_form').serialize(),
                success: function (response) {
                    if (response.status == "error") {
                        showToastrMessage('{{ __('messages.errorTitle') }}', '{{__('messages.error')}}', 'error');
                        $('#error').html('');
                        var arr = response.msg;
                        var alert = '';
                        $.each(arr, function (index, value) {
                            if (value.length != 0) {
                                alert += '<p><span class="fa fa-close"></span> ' + value + '</p>';
                            }
                        });
                        $('#error_edit').html('<div class="alert alert-danger alert-dismissable"><button class="close" data-close="alert"></button> ' + alert + '</div>');
                        $("#submitbutton_edit").prop('disabled', false);
                    } else {
                        $('#static_license').modal('hide');
                        $('#error').html('');
                        $("#submitbutton_edit").prop('disabled', false);
                        if (table == 'country') {
                            table2._fnDraw();
                        } else {
                            table1._fnDraw();
                        }

                        showToastrMessage(response.msg, response.status, 'success');
                    }

                },
                error: function (xhr, textStatus, thrownError) {
                }
            });
        }
    </script>
@stop
