@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!!  HTML::style("assets/global/plugins/bootstrap-select/bootstrap-select.min.css")  !!}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("core.featureSettings")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.dashboard') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">{{trans('core.settings')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("core.featureSettings")</span>
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
                        <i class="fa fa-cog font-dark"></i>@lang("core.featureSettings")
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM ---------------------->
                    {!!  Form::open(['method' => 'PATCH','files' => true, 'route' => ['admin.company_setting.update', $company_id],'class'=>'form-horizontal'])  !!}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.awards')}}: </label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="award_feature"
                                       @if($loggedAdmin->company->award_feature==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.attendance')}}:</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="attendance_feature"
                                       @if($loggedAdmin->company->attendance_feature==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.noticeBoard')}}:</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="notice_feature"
                                       @if($loggedAdmin->company->notice_feature==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">@lang("core.payroll"):</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="payroll_feature"
                                       @if($loggedAdmin->company->payroll_feature==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.leaveApplication')}}:</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="leave_feature"
                                       @if($loggedAdmin->company->leave_feature==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.expenseClaim')}}:</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="expense_feature"
                                       @if($loggedAdmin->company->expense_feature==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('menu.holiday')}}:</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="holidays_feature"
                                       @if($loggedAdmin->company->holidays_feature==1)checked
                                       @endif data-on-color="success" data-on-text="{{trans('core.btnYes')}}"
                                       data-off-text="{{trans('core.btnNo')}}" data-off-color="danger">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('menu.jobsPosted')}}:</label>
                            <div class="col-md-6">
                                <input type="checkbox" value="1" class="make-switch" name="jobs_feature"
                                       @if($loggedAdmin->company->jobs_feature==1)checked @endif data-on-color="success"
                                       data-on-text="{{trans('core.btnYes')}}" data-off-text="{{trans('core.btnNo')}}"
                                       data-off-color="danger">
                            </div>
                        </div>
                        <!------------------------- END FORM ----------------------->

                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" data-loading-text="{{trans('core.btnUpdating')}}..."
                                        class="btn green"><i class="fa fa-check"></i> {{trans('core.btnUpdate')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    {!!  Form::close()  !!}
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>

        </div>
        <!-- END PAGE CONTENT-->


    @stop

    @section('footerjs')

        <!-- BEGIN PAGE LEVEL PLUGINS -->
            {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js") !!}
            {!!  HTML::script('assets/admin/pages/scripts/components-dropdowns.js')  !!}



            <script>
                jQuery(document).ready(function () {
                    ComponentsDropdowns.init();
                });

            </script>
            <!-- END PAGE LEVEL PLUGINS -->
@stop
