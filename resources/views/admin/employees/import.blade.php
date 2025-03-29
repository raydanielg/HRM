@extends('admin.adminlayouts.adminlayout')

@section('head')
{!! HTML::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')!!}
{!! HTML::style('assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css')!!}
{!! HTML::style('assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css')!!}
<style>
    .leadBox {
        min-height:320px;
        width:250px;
        margin: 10px;
    }
    .leadOptions {
        padding: 10px;
        height: 150px;
        vertical-align: middle;
    }
    .unchanged {
        border: 2px solid #d0d0d0;
    }
    .matched {
        border: 2px solid #52bad5;
    }
    .unmatched {
        border: 2px solid #EE836E;
    }
    .leadSamples .sampleHeading, .leadSamples .sample {
        padding: 5px 15px;
        margin: 0px;
    }
    .unchanged .sampleHeading {
        background-color: #e0e0e0;
    }
    .unchanged .sample {
        background-color: #ffffff;
    }
    .matched .sampleHeading {
        background-color: #52BAD5;
    }
    .matched .sample {
        background-color: #B1E0EC;
    }
    .unmatched .sampleHeading {
        background-color: #EE836E;
    }
    .unmatched .sample {
        background-color: #FBE3E4;
    }
    .leadBox .unmatchedWarning {
        color: #EE836E;
    }
    .leadBox .notimported {
        padding: 5px 10px;
        margin: 5px 0px;
    }
    .sampleHeading, .sample {
        overflow-x: hidden;
        max-height: 31px;
        overflow-y: hidden;
    }
</style>
@stop


@section('mainarea')

<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="page-title"><h1>
            {{ trans('pages.employees.importTitle')}}
        </h1></div>
</div>
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a onclick="loadView('{{route('admin.employees.index')}}')">{{ trans("pages.employees.indexTitle") }}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active">{{ trans('pages.employees.importTitle')}}</span>
    </li>
</ul>
<!-- END PAGE HEADER-->

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption red-sunglo">
                    <i class="fa fa-file-text-o font-red-sunglo"></i> @lang('pages.employees.uploadCsv')
                </div>
            </div>
            <div class="portlet-body">
                <p>@lang("messages.uploadMessage")</p>
                <form class="form form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-md-2">{{ trans("core.csvFile") }} {!! help_text("importFileInfo") !!}</label>

                        <div class="col-md-5">
                            <div class="fileinput fileinput-new"  id="fileInputWrapper">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp; <span
                                                class="fileinput-filename">
                                        </span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new">
                                            {{ trans('core.selectFile')}} </span>
                                        <span class="fileinput-exists">
                                            @lang("core.change") </span>
                                        <input id="fileupload" type="file" name="file" data-url="{{ route("admin.employees.importUpload") }}" />
                                    </span>
                                    <a href="#" class="input-group-addon btn red fileinput-exists"
                                       data-dismiss="fileinput">
                                        @lang("core.remove")
                                    </a>
                                </div>
                            </div>
                            {{-- Upload progress --}}
                            <div class="progress progress-striped active" id="uploadProgress" style="display: none; margin-top: 5px;">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    @stop

    @section('footerjs')
        {!! HTML::script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')!!}
        {!! HTML::script('assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js')!!}
        {!! HTML::script('assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js')!!}



    <script type="text/javascript">
        $('#fileupload').fileupload({
            dataType: 'json',
            type: "POST",
            submit: function() {
                $("#fileInputWrapper").hide();
                $("#uploadProgress").find(".progress-bar").css("width", "0%").attr("aria-valuenow", "0");
                $("#uploadProgress").show();
            },
            done: function (e, response) {
                if (response.result.status == "fail") {
                    showToastrMessage(response.result.errors.file[0], "@lang("core.error")", "error");
                    $("#fileInputWrapper").show();
                    $("#uploadProgress").hide();
                }
                else {
                   loadView(response.result.url);
                }
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $("#uploadProgress").find(".progress-bar").css("width", progress + "%").attr("aria-valuenow", progress);
            },
            fail: function(e, response) {
                showToastrMessage("@lang("messages.employeeImportError")", "@lang("core.error")", "error");
                $("#fileInputWrapper").show();
                $("#uploadProgress").hide();
            }
        });
    </script>
    {{--INLCUDE ERROR MESSAGE BOX--}}

    {{--END ERROR MESSAGE BOX--}}
    @stop
