@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-summernote/summernote.css")!!}

    <!-- BEGIN THEME STYLES -->

@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.noticeBoard.createTitle")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.noticeboards.index') }}')">{{trans('pages.noticeBoard.indexTitle')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">{{trans('pages.noticeBoard.createTitle')}}</span>
            </li>

        </ul>

    </div>
    <!-- END PAGE HEADER-->

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            {{--INLCUDE ERROR MESSAGE BOX--}}

            {{--END ERROR MESSAGE BOX--}}


            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-blue">
                        <i class="fa fa-plus font-blue"></i>@lang("core.noticeDetails")
                    </div>
                    <div class="actions">
                        <input type="checkbox"
                               onchange="ToggleEmailNotification('notice_notification');return false;"
                               class="make-switch" name="notice_notification"
                               @if($loggedAdmin->company->notice_notification==1)checked @endif data-on-color="success"
                               data-on-text="{{trans('core.btnYes')}}" data-off-text="{{trans('core.btnNo')}}"
                               data-off-color="danger">
                        <strong>{{trans('core.emailNotification')}}</strong>
                    </div>
                </div>

                <div class="portlet-body form">

                    <!-- BEGIN FORM-->
                    {!! Form::open(array('route'=>"admin.noticeboards.store",'class'=>'form-horizontal ajax_form','method'=>'POST')) !!}


                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.title')}}: <span class="required">
                                        * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" id="title"
                                       placeholder="{{trans('core.title')}}">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.description')}}: <span class="required">
                                            * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="description" name="description"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-9">

                                    <button type="button" class="btn green" id="noticeCreate"
                                            onclick="ajaxCreateNotice()">
                                        {{trans('core.btnSubmit')}} </button>

                                </div>
                            </div>
                        </div>
                    {!!  Form::close()  !!}
                    <!-- END FORM-->

                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->


@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-select/bootstrap-select.min.js") !!}
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/select2/select2.min.js") !!}
    {!! HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js") !!}
    {!! HTML::script("assets/global/plugins/bootstrap-summernote/summernote.min.js") !!}
    {!! HTML::script('assets/js/ajaxform/jquery.form.min.js')!!}
    <script>
        $('#description').summernote({height: 300});

        // Javascript function to update the company info and Bank Info
        function ajaxCreateNotice() {

            var val = $('#description').val();

            var url = "{{ route('admin.noticeboards.store') }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '.ajax_form',
                data: $('.ajax_form').serialize(),
            });
        }

    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
