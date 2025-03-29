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
                                        <a class="btn green" data-toggle="modal" onclick="showAdd()">
                                            {{ trans('core.btnAddFaq') }}
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
                            <th> Category</th>
                            <th> Title</th>
                            <th> Content</th>
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

    <div id="add_edit_form" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{$pageTitle}}</h4>
                </div>
                <div class="modal-body" id="add_edit_body">
                    {{--Ajax replace content--}}
                </div>
            </div>
        </div>
    </div>

    {{--MODAL CALLING--}}
    @include('admin.common.delete')
    {{--MODAL CALLING END--}}

@stop



@section('footerjs')
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/global/plugins/select2/js/select2.js")!!}

    <!-- END PAGE LEVEL PLUGINS -->

    <script>


        var table1 = $('#table').dataTable({
            {!! $datatabble_lang !!}
            processing: true,
            serverSide: true,
            "ajax": "{{ URL::route("admin.faqs") }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'title', name: 'title' },
                { data: 'content_text', name: 'content_text' },
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
            $('#add_edit_form').modal('show');
            $("body").addClass("modal-open");

            var get_url = "{{ route('admin.faq.create') }}";

            $("#add_edit_body").html('<div class="text-center">{!!  HTML::image('assets/loader.gif') !!}</div>');

            $.ajax({
                type: "GET",
                url: get_url,
                data: {}
            }).done(function (response) {
                $("#add_edit_body").html(response);
            });
        }


        function showEdit(id) {
            $('#add_edit_form').modal('show');
            $("body").addClass("modal-open");

            var get_url = "{{ route('admin.faq.edit',':id') }}";


            get_url = get_url.replace(':id', id);

            $("#add_edit_body").html('<div class="text-center">{!!  HTML::image('assets/loader.gif') !!}</div>');

            $.ajax({
                type: "GET",
                url: get_url,
                data: {}
            }).done(function (response) {
                $("#add_edit_body").html(response);
            });
        }

        function addData() {
            var get_url = "{{ route('admin.faq.store') }}";

            $.easyAjax({
                url: get_url,
                type: "POST",
                data: $(".add_form").serialize(),
                container: "#add_edit_form",
                success: function (response) {

                    if (response.status == 'success')
                    {
                        $('#add_edit_form').modal('hide');
                        table1._fnDraw();
                    }
                }
            });
        }

        function updateData(id) {
            var get_url = "{{ route('admin.faq.update',':id') }}";
            get_url = get_url.replace(':id', id);
            $.easyAjax({
                url: get_url,
                type: "PUT",
                data: $(".edit_form").serialize(),
                container: "#add_edit_form",
                success: function (response) {
                    if (response.status == 'success')
                    {
                        $('#add_edit_form').modal('hide');
                        table1._fnDraw();
                    }
                }
            });
        }

        function del(id,faq)
        {

            $('#deleteModal').modal('show');
            $("#deleteModal").find('#info').html('{!!  __('messages.faqDeleteConfirm') !!}');

            $('#deleteModal').find("#delete").off().click(function()
            {
                var url = "{{ route('admin.faq.destroy',':id') }}";
                url = url.replace(':id',id);
                $.ajax({

                    type: "DELETE",
                    url : url,
                    dataType: 'json',
                    data: {"id":id}

                }).done(function(response)
                {
                    if(response.success == "deleted")
                    {
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $('#deleteModal').modal('hide');

                        var msg = prepareMessage("{!! trans("messages.faqDeleteMessage") !!}", ":faq", faq);
                        showToastrMessage(msg, '{{__('core.success')}}', 'success');
                        table1._fnDraw();
                    }
                });
            })

        }
    </script>
@stop
