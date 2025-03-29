@extends('admin.adminlayouts.adminlayout')

@section('head')


        <!-- BEGIN PAGE LEVEL STYLES -->

{!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") !!}
{!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
{!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
{!! HTML::style("assets/global/plugins/uniform/css/uniform.default.min.css")!!}

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
            <a onclick="loadView('{{ route('admin.dashboard.index') }}')" >{{ trans('core.dashboard') }}</a>
            <i class="fa fa-circle"></i>
        </li>

        <li>
            <span class="active">{{trans('core.managers')}}</span>
        </li>

    </ul>

</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">


        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div id="load">



        </div>
        <div class="portlet light bordered">


            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row ">
                        <div class="col-md-6">
                            <a class="btn green" onclick="addManagers()">
                                {{trans('core.btnAddManager')}}
                                <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-md-6 form-group text-right">
                            <span id="load_notification"></span>
                            <input  type="checkbox"  onchange="ToggleEmailNotification('admin_add');return false;" class="make-switch" name="admin_add" @if($loggedAdmin->company->admin_add==1)checked	@endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}" data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            <strong>{{trans('core.emailNotification')}}</strong><br>
                        </div>
                    </div>
                </div>


                <table class="table table-striped table-bordered table-hover" id="admins">
                    <thead>
                        <tr>
                            <th> @lang("core.serialNo") </th>
                            <th> {{trans('core.name')}} </th>
                            <th> {{trans('core.email')}} </th>
                            <th> {{trans('core.department')}} </th>

                            <th class="text-center"> {{trans('core.actions')}} </th>
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
{{--MODAL CALLING--}}
@include('admin.common.delete')
{{--MODAL CALLING END--}}

{{--MODALS--}}

<div id="static" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                <h4 class="modal-title"><strong><i class="fa fa-plus"></i> {{trans('core.addNewManager')}}</strong></h4>
            </div>
            <div class="modal-body" style="max-height: 800px">
                <div class="form">

                    <!-- BEGIN FORM-->
                    {!! Form::open(array('route'=>"admin.managers.store",'class'=>'form-horizontal ','method'=>'POST','id'=>'add_form')) !!}

                    <div id="error"></div>
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.name')}}: <span class="required">
                                    * </span>
                            </label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="{{trans('core.name')}}">
                                <span class="help-block" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.email')}}: <span class="required">
                                    * </span>
                            </label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" name="email" id="email"
                                       placeholder="{{trans('core.email')}}">
                                <span class="help-block" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.password')}}: <span class="required">
                                    * </span>
                            </label>

                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="{{trans('core.password')}}">
                                <span class="help-block" ></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.confirmPassword')}}: <span
                                        class="required">
                                    * </span>
                            </label>

                            <div class="col-md-8">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                       placeholder="{{trans('core.confirmPassword')}}">
                                <span class="help-block" ></span>
                            </div>
                        </div>

                        <div class="form-group" id="departments">
                            <label class="col-md-4 control-label">{{trans('core.departments')}}: <span
                                        class="required">
                                    * </span>
                            </label>

                            <div class="col-md-8">
                                <div class="checkbox-list">
                                    @foreach($department as $dept)
                                    <label>
                                        <input name="departments[]"  id="departments[]" type="checkbox" value="{{$dept->id}}"> {{$dept->name}} </label>
                                    @endforeach
                                    <span class="help-block" id="dep_help"></span>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- END FORM-->
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" id="submitbutton_add" onclick="addAdminSubmit();return false;"
                                    class=" btn green">{{trans('core.btnSubmit')}}
                            </button>

                        </div>
                    </div>
                </div>
                {!!  Form::close()  !!}
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>
</div>

{{--MODALS--}}

{{--EDIT  MODALS--}}

<div id="static_edit" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" id="edit-form-body">
        <div class="modal-content">

            <div class="modal-body" id="edit-modal-body">
            </div>
        </div>

    </div>
</div>


{{--EDIT MODALS--}}
@stop

@section('footerjs')

        <!-- BEGIN PAGE LEVEL PLUGINS -->
{!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
{!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") !!}
{!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
{!! HTML::script("assets/global/plugins/uniform/jquery.uniform.min.js")!!}

        <!-- END PAGE LEVEL PLUGINS -->
<script>


    var table = $('#admins').dataTable( {
        {!! $datatabble_lang !!}
        processing: true,
        serverSide: true,
        "ajax": "{{ URL::route("admin.ajax_managers") }}",
        "aaSorting": [[ 0, "asc" ]],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'dept', name: 'dept' },
            { data: 'edit', name: 'edit' },
        ],
        "lengthMenu": [
            [5, 15, 20, -1],
            [5, 15, 20, "All"] // change per page values here
        ],
        "sPaginationType": "full_numbers",
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            var oSettings = this.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
            return nRow
        }

    });

    function del(id)
    {

        $('#deleteModal').modal('show');
        $("#deleteModal").find('#info').html('@lang("messages.adminDeleteConfirm")');
        $('#deleteModal').find("#delete").off().click(function()
        {
            var url = "{{ route('admin.managers.destroy',':id') }}";
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
                    $('#row'+id).fadeOut(500);
                    table._fnDraw();
                    showToastrMessage('@lang("messages.adminDeleteMessage")', '{{__('messages.success')}}', 'success');
                }
            });
        })

    }
    function addAdminSubmit(){
        $('.form-group').removeClass('has-error');
        $('.help-block').html('');
        $("#error").html('<div class="alert alert-info">{{trans('messages.submitting')}}..</div>');
        $("#submitbutton_add").prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: "{{route('admin.managers.store')}}",
            dataType: "JSON",
            data: $('#add_form').serialize(),
            success: function(response) {
            $('#error').html('');
                if(response.status == "success"){
                    resposeArray = {
                    "status" : "success",
                    "toastrHeading" :"{{trans('messages.success')}}",
                    "toastrMessage" : "{{trans("messages.successAdd")}}",
                    "toastrType" : "success",
                    "action" : "showToastr"
                    };

                    $('#static').modal('hide');
                    $('#add_form').trigger("reset");
                    $("#submitbutton_add").prop('disabled', false);
                    table._fnDraw();
                    showResponseMessage(resposeArray,"errors");
                }
                else{
                if(typeof response.errors.departments != 'undefined' ){
                    $('#departments').addClass('has-error');
                    $('#dep_help').html(response.errors.departments)
                }
                showResponseMessage(response,'errors');
                $('#submitbutton_add').attr("disabled",false);
                }
            },
            error: function(xhr, textStatus, thrownError) {

            }
        });
    }

    function showEdit(id)
    {
        $('.form-group').removeClass('has-error');
        $('.help-block').html('');
        $('#static_edit').modal('show');
        var get_url = "{{ route('admin.managers.edit',':id') }}";
        get_url = get_url.replace(':id',id);

        $("#edit-modal-body").html('<div class="text-center">{!!  HTML::image('assets/loader.gif') !!}</div>');

        $.ajax({
            type: "GET",
            url : get_url,
            data: {}
        }).done(function(response)
        {
            $("#edit-form-body").html(response);
        });
    }
    function updateData(id){
         $('.form-group').removeClass('has-error');
         $('.help-block').html('');
        var get_url = "{{ route('admin.managers.update',':id') }}";
        get_url = get_url.replace(':id',id);
        $("#error_edit").html('<div class="alert alert-info">{{trans('messages.submitting')}}..</div>');
        $("#submitbutton_edit").prop('disabled', true);

        $.ajax({
            type: 'PUT',
            url: get_url,
            dataType: "JSON",
            data: $('#edit_form').serialize(),
            success: function(response) {
                $("#error_edit").html('');
                if(response.status == "success"){
                    resposeArray = {
                    "status" : "success",
                    "toastrHeading" :"{{trans('messages.success')}}",
                    "toastrMessage" : "{{trans("messages.successUpdate")}}",
                    "toastrType" : "success",
                    "action" : "showToastr"
                    };
                    $('#error').html('');
                    $('#static_edit').modal('hide');
                    $("#submitbutton_edit").prop('disabled', false);
                    table._fnDraw();
                    showResponseMessage(resposeArray,"error");
                }
                else{
                if(typeof response.errors.departments != 'undefined'){
                    $('#dept_edit').addClass('has-error');
                    $('#dept_edit_message').html(response.errors.departments)
                }
                if(typeof response.errors.name != 'undefined'){
                    $('#name_edit').addClass('has-error');
                    $('#name_edit_message').html(response.errors.name)
                }
                if(typeof response.errors.email != 'undefined'){
                    $('#email_edit').addClass('has-error');
                    $('#email_edit_message').html(response.errors.email)
                }
                showResponseMessage(response,"error");
                $("#submitbutton_edit").prop('disabled', false);
                }

            },
            error: function(xhr, textStatus, thrownError) {
                $('#error').html('Error Updating');
            }
        });
    }

    function addManagers(){
        $('.form-group').removeClass('has-error');
        $('.help-block').html('');
        $('#static').modal('show');
    }

</script>
{{--INLCUDE ERROR MESSAGE BOX--}}

{{--END ERROR MESSAGE BOX--}}
@stop
