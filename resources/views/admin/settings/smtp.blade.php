@extends('admin.adminlayouts.adminlayout')

@section('head')

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
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span class="active"> {{trans('core.settings')}}</span>
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

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::model($setting, ['method' => 'POST','class'=>'form-horizontal', 'id' => 'updateSettings'])  !!}

                    <div id="alert">
                        @if($setting->mail_driver =='smtp')
                            @if($setting->verified)
                                <div class="alert alert-success">{{__('messages.smtpSuccess')}}</div>
                            @else
                                <div class="alert alert-danger">{{__('messages.smtpError')}}</div>
                            @endif
                        @endif
                    </div>

                    <input type="hidden" name="type" value="smtpSetting">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">MAIL DRIVER:
                            </label>
                            <div class="col-md-6">
                                <label class="radio-inline"><input type="radio"
                                                                   class="checkbox"
                                                                   onchange="getDriverValue(this);"
                                                                   value="mail"
                                                                   @if($setting->mail_driver == 'mail') checked
                                                                   @endif name="mail_driver">Mail</label>
                                <label class="radio-inline m-l-10"><input type="radio"
                                                                          onchange="getDriverValue(this);"
                                                                          value="smtp"
                                                                          @if($setting->mail_driver == 'smtp') checked
                                                                          @endif name="mail_driver">SMTP</label>
                            </div>


                        </div>
                        <div id="smtp_div">
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ trans('core.mailHost') }}:
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mail_host" placeholder=""
                                           value="{{ $setting->mail_host }}">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">{{trans('core.mailPort')}}:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mail_port"
                                           value="{{ $setting->mail_port }}" placeholder="">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">{{trans('core.mailUsername')}}:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mail_username"
                                           value="{{ $setting->mail_username}}" placeholder="">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">{{trans('core.mailPassword')}}:</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="mail_password"
                                           value="{{ $setting->mail_password}}" placeholder="">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ trans('core.mailEncryption') }}:</label>
                                <div class="col-md-6">
                                    {!! Form::select('mail_encryption', ['' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL'], \Input::old('mail_encryption'),['class'=>'form-control']) !!}
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <!------------------------- END FORM ----------------------->

                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-1">
                                <button type="submit" onclick="smtpSetting();return false;"
                                        class="btn green">{{trans('core.btnUpdate')}}</button>

                            </div>
                            <div class="col-md-4">
                                <button type="submit" onclick="showModal();return false;"
                                        class="btn blue">{{trans('core.btnSendTestMail')}}</button>

                            </div>
                        </div>
                    </div>
                    {!! Form::close()  !!}
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->

    <div id="showModal" class="modal fade" tabindex="-1" data-backdrop="static_approve" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Send test email to below email address</h4>
                </div>
                <div class="modal-body">
                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::open(['method' => 'POST','class'=>'form-horizontal', 'id' => 'testEmail'])  !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Email:
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="test_email" value="{{ $setting->email }}">
                                <span class="help-block"></span>
                            </div>
                        </div>


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">@lang('core.btnCancel')</button>
                    <input type="button" name="application_status" id="confirm"
                           class="btn green" value="@lang('core.btnSubmit')">
                </div>
                {!! Form::close()  !!}
            </div>
        </div>
    </div>

@stop

@section('footerjs')

    <script>
        function smtpSetting() {

            var url = '{{route('admin.email-settings.updateMailConfig')}}';

            $.easyAjax({
                url: url,
                type: "POST",
                container: '#updateSettings',
                messagePosition: "inline",
                data: $('#updateSettings').serialize(),
                success: function (response) {
                    if (response.status == 'error') {
                        $('#alert').prepend('<div class="alert alert-danger">{{__('messages.smtpError')}}</div>')
                    } else {
                        $('#alert').show();
                    }
                }
            })

        }


        function showModal() {
            $('#showModal').modal('show');
            $('#showModal').find("#confirm").off().click(function () {

                var url = "{{ route('admin.smtp_settings.send-test-email') }}";
                $.easyAjax({
                    type: 'POST',
                    url: url,
                    container: '#testEmail',
                    messagePosition: 'inline',
                    data: $('#testEmail').serialize(),
                });

            });
        }

        function getDriverValue(sel) {
            if (sel.value == 'mail') {
                $('#smtp_div').hide();
                $('#alert').hide();
            } else {
                $('#smtp_div').show();
                $('#alert').show();
            }
        }

        @if ($setting->mail_driver == 'mail')
        $('#smtp_div').hide();
        $('#alert').hide();
        @endif
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
