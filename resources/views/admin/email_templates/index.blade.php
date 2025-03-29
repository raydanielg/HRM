@extends('admin.adminlayouts.adminlayout')

@section('head')


    <!-- BEGIN PAGE LEVEL STYLES -->
   
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-summernote/summernote.css")!!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head"><div class="page-title"><h1>
        {{$pageTitle}}
    </h1></div></div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                                          <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.home') }}</a>
                     <i class="fa fa-circle"></i>
                 </li>
            <li>
                <span class="active">Email Templates</span>

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
                {{--<div class="portlet-title">--}}
                    {{--<div class="caption font-dark">--}}
                        {{--<i class="fa fa-envelope font-dark"></i> Email Templates--}}
                    {{--</div>--}}
                    {{--<div class="tools">--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="portlet-body">


                    <table class="table table-striped table-bordered table-hover" id="emails">
                        <thead>
                        <tr>

                            <th> EmailID </th>
                            <th> Subject </th>
                            <th> TEXT </th>
                            <th> Created At </th>
                            <th class="text-center"> {{trans('core.action')}} </th>
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

    {{--EDIT  MODALS--}}

    <div id="static_edit" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><strong><i class="fa fa-edit"></i> {{trans('core.edit')}} Email Template</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="portlet-body form" id="edit-form-body">
                        {{--Ajax Data--}}
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>

        </div>
    </div>


    {{--EDIT MODALS--}}
@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-summernote/summernote.min.js") !!}
    <script>
        $('#body').summernote({height: 300});
    </script>
    <!-- END PAGE LEVEL PLUGINS -->

    <script>


      var table =   $('#emails').dataTable( {
            {!! $datatabble_lang !!}
            processing: true,
          serverSide: true,
            "ajax": "{{ URL::route("admin.ajax_email_templates") }}",
            "aaSorting": [[ 3, "desc" ]],
            columns: [
                { data: 'email_id', name: 'email_id' },
                { data: 'subject', name: 'subject' },
                { data: 'body', name: 'body' },
                { data: 'created_at', name: 'created_at', "visible": false },
                { data: 'edit', name: 'edit', "bSortable": false  }
            ],
            "iDisplayLength": 10,
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            }

        });





        function showEdit(id)
        {
            $('#static_edit').modal('show');
            $("body").addClass("modal-open");
            var get_url = "{{ route('admin.email_templates.edit',':id') }}";
            get_url = get_url.replace(':id',id);

            $("#edit-form-body").html('<div class="text-center">{!!  HTML::image('assets/loader.gif') !!}</div>');

            $.ajax({
                type: "GET",
                url : get_url,
                data: {}
            }).done(function(response)
            {
                $("#edit-form-body").html(response);
                $('#body').summernote({height: 300});
            });
        }

        function updateData(id){
            var get_url = "{{ route('admin.email_templates.update',':id') }}";
            get_url = get_url.replace(':id',id);
            $("#error_edit").html('<div class="alert alert-info">{{trans('messages.submitting')}}..</div>');
            $("#submitbutton_edit").prop('disabled', true);

            $.ajax({
                type: 'PUT',
                url: get_url,
                dataType: "JSON",
                data: {'subject':$('#subject').val(),'body':$('#body').code(),'id':id},
                success: function(response) {
                    if(response.status == "error")
                    {
                        showToastrMessage('{{ __('messages.errorTitle') }}', '{{__('messages.error')}}', 'error');
                        $('#error').html('');
                        var arr = response.msg;
                        var alert ='';
                        $.each(arr, function(index, value)
                        {
                            if (value.length != 0)
                            {
                                alert += '<p><span class="fa fa-close"></span> '+ value+ '</p>';
                            }
                        });
                        $('#error_edit').html('<div class="alert alert-danger alert-dismissable"><button class="close" data-close="alert"></button> '+alert+'</div>');
                        $("#submitbutton_edit").prop('disabled', false);
                    }else{
                        $('#static_edit').modal('hide');
                        $('#error').html('');
                        $("#submitbutton_edit").prop('disabled', false);
                        table._fnDraw();
                        showToastrMessage(response.msg, response.status, 'success');
                    }

                },
                error: function(xhr, textStatus, thrownError) {

                }
            });
        }
    </script>
@stop
