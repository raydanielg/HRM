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
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">@lang("core.settings")</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("core.profileSettings")</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-lg-12">
            <div id="load">
                {{--INLCUDE ERROR MESSAGE BOX--}}

                {{--END ERROR MESSAGE BOX--}}
            </div>
        </div>
        <div class="col-md-6">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->


            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-lock font-dark"></i>{{trans('core.loginDetails')}}
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::open(['class'=>'form-horizontal ajax-form-login'])  !!}

                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.name')}}: <span class="required">
                                        * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="@lang("core.name")"
                                       value="{{ $admin->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.loginEmail')}}: <span class="required">
                                            * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email"
                                       placeholder="@lang("core.loginEmail")" value="{{ $admin->email}}">
                            </div>
                        </div>
                        <input type="hidden" name="type" value="login">
                        <!------------------------- END FORM ----------------------->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-4 col-md-9">
                                <button type="button" onclick="updateLogin();return false;" class="btn green"><i
                                            class="fa fa-check"></i> {{trans('core.btnUpdate')}}</button>

                            </div>
                        </div>
                    </div>
                    {!! Form::close()  !!}
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-key font-dark"></i>{{trans('core.change')}} {{trans('core.password')}}
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM Change Password---------------------->
                    {!!  Form::open(['class'=>'form-horizontal ajax-form-password'])  !!}

                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.password')}}: <span class="required">
                                                                        * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password"
                                       placeholder="{{trans('core.password')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.confirmPassword')}}: <span
                                        class="required">
                                                                            * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation"
                                       placeholder="{{trans('core.confirmPassword')}}">
                            </div>
                        </div>
                        <!------------------------- END FORM Change Password ----------------------->

                    </div>
                    <input type="hidden" name="type" value="password">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-4 col-md-9">
                                <button type="button" onclick="updatePassword();return false;" class="btn green"><i
                                            class="fa fa-check"></i> {{trans('core.btnUpdate')}}</button>

                            </div>
                        </div>
                    </div>
                    {!!  Form::close()  !!}
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->



@stop

@section('footerjs')



    <script>

        function updateLogin() {
            $.easyAjax({
                type: 'POST',
                url: "{{ route(admin()->type.'.profile_settings.update') }}",
                data: $(".ajax-form-login").serialize(),
                container: ".ajax-form-login",
            });
        }
        function updatePassword() {
            $.easyAjax({
                type: 'POST',
                url: "{{ route(admin()->type.'.profile_settings.update') }}",
                data: $(".ajax-form-password").serialize(),
                container: ".ajax-form-password",
            });
        }
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
