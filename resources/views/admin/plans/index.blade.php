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

                <div class="portlet-body">

                    @if($loggedAdmin->manager!=1)
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a class="btn green" data-toggle="modal" href="javascript:;"  onclick="showAdd()">
                                            {{ trans('core.btnAddPlan') }}
                                            <i class="fa fa-plus"></i> </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                    @endif

                    <table class="table table-striped table-bordered table-hover" id="table">
                        <thead>
                        <tr>
                            <th> Sr No.</th>
                            <th> Plan Name</th>
                            <th> Stripe ID</th>
                            <th> Users Count</th>
                            <th> Price(USD)</th>
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
            "ajax": "{{ URL::route("admin.plans") }}",
//            "aaSorting": [[ 1, "asc" ]],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'plan_name', name: 'plan_name' },
                { data: 'stripe_monthly_plan_id', name: 'stripe_monthly_plan_id' },
                { data: 'start_user_count', name: 'start_user_count' },
                { data: 'monthly_price', name: 'monthly_price' },
                { data: 'status', name: 'status' },
                { data: 'edit', name: 'edit', "bSortable": false  }
            ],
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

        function showAdd() {
            console.log('sdf');
            $('#static_license').modal('show');
            $("body").addClass("modal-open");

            var get_url = "{{ route('admin.plans.create') }}";

            $("#edit-form-body").html('<div class="text-center">>{!!  HTML::image('assets/loader.gif') !!}</div>');

            $.ajax({
                type: "GET",
                url: get_url,
                data: {}
            }).done(function (response) {
                $("#license-form-body").html(response);

            });
        }


        function showEdit(id) {
            $('#static_license').modal('show');
            $("body").addClass("modal-open");

            var get_url = "{{ route('admin.plans.edit',':id') }}";


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

        function addData(id) {
            var get_url = "{{ route('admin.plans.store') }}";

            $.easyAjax({
                url: get_url,
                type: "POST",
                data: $("#add_form_plan").serialize(),
                container: "#add_form_plan",
                success: function (response) {
                    if(response.status === 'success') {
                        $('#static_license').modal('hide');
                        table1._fnDraw();
                    }
                }
            });
        }

        function updateData(id) {
            var get_url = "{{ route('admin.plans.update',':id') }}";
            get_url = get_url.replace(':id', id);
            $.easyAjax({
                url: get_url,
                type: "PUT",
                data: $("#edit_form_plan").serialize(),
                container: "#edit_form_plan",
                success: function (response) {
                    if(response.status === 'success') {
                        $('#static_license').modal('hide');
                        table1._fnDraw();
                    }

                }
            });
        }
    </script>
@stop
