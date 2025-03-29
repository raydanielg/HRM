@extends('admin.adminlayouts.adminlayout')

@section('head')


        <!-- BEGIN PAGE LEVEL STYLES -->
{!! HTML::style("assets/admin/pages/css/blog.min.css")!!}
{!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
{!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
{!! HTML::style("assets/global/plugins/bootstrap-summernote/summernote.css")!!}
        <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


        <!-- BEGIN PAGE HEADER-->
<div class="page-head"><div class="page-title"><h1>
            @lang("pages.updates.createTitle")
        </h1></div></div>
<div class="page-bar">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a onclick="loadView('{{route('admin.updates.index')}}')">{{trans('pages.updates.indexTitle')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">@lang("pages.updates.createTitle")</span>
        </li>

    </ul>

</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered">

            <div class="portlet-body form">
                <form class="form-horizontal ajax_form" method="post" action="{{ route("admin.updates.store") }}">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('core.title')}}: <span class="required">
                                * </span>
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="title" id="title" placeholder="{{trans('core.title')}}" >
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('core.excerpt')}}: <span class="required">
                                * </span>
                        </label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="excerpt" name="excerpt" ></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('core.description')}}: <span class="required">
                                * </span>
                        </label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="description" name="description" ></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">{{trans('core.status')}}: <span class="required">
                                * </span>
                        </label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control">
                                <option value="Unpublished">Unpublished</option>
                                <option value="Published">Published</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </form>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="button"
                                    class="btn green" id="updateSubmit" onclick="ajaxCreateUpdate()">{{trans('core.btnSubmit')}}</button>
                        </div>
                    </div>
                </div>
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
{!! HTML::script("assets/global/plugins/bootstrap-summernote/summernote.min.js") !!}
{!! HTML::script('assets/js/ajaxform/jquery.form.min.js')!!}
        <!-- END PAGE LEVEL PLUGINS -->

<script>

    $('#excerpt').summernote({
        height: 200,
        onImageUpload: function(files) {
            sendFile(files[0], "#excerpt");
        }
    });

    $('#description').summernote({
        height: 500,
        onImageUpload: function(files) {
            sendFile(files[0], "#description");
        }
    });

    function sendFile(file, editor) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: "POST",
            url: "{{ route("admin.summernote.image_upload") }}",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                $(editor).summernote("insertImage", url);
            }
        });
    }

    function ajaxCreateUpdate() {
        var that = $(".ajax_form");
        var posturl = that.attr('action');
        hideErrors();
        that.ajaxSubmit({
            url: posturl,
            dataType: 'json',
            method:'POST',
            beforeSend: function () {
                $('#updateSubmit').attr("disabled", true);
            },
            data: {
                "excerpt": $('#excerpt').summernote('code'),
                "description": $('#description').summernote('code')
            },
            success: function (response) {
                $('#updateSubmit').attr("disabled", false);
                if(response.status == "success"){
                    resposeArray = {
                        "status" : "success",
                        "toastrHeading" :"{{trans('messages.success')}}",
                        "toastrMessage" : "{{trans("messages.updateCreateMessage")}}",
                        "toastrType" : "success",
                        "action" : "showToastr"
                    };
                    showResponseMessage(resposeArray,"error");
                    loadView("{{route('admin.updates.index')}}");
                }
                else{
                    showResponseMessage(response,'error');
                }
            },
            error: function (xhr, textStatus, thrownError) {
                $('#updateSubmit').attr("disabled", false);
                showResponseMessage(xhr.responseText, "error");

            }
        });
        return false;
    }
</script>
@stop
