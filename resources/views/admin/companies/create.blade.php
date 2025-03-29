@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css") !!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css") !!}

    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                Add New Company
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.companies.index') }}')">Companies</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span class="active">Add New Company</span>
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
                {{--<i class="fa fa-desktop font-dark"></i>{{trans('core.add')}} {{$pageTitle}}--}}
                {{--</div>--}}
                {{--<div class="tools">--}}
                {{--</div>--}}
                {{--</div>--}}

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::open(['method' => 'POST','files' => true,'class'=>'form-horizontal ajax_form'])  !!}

                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-2">{{trans('core.companyLogo')}}</label>
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">

                                        {!! HTML::image('http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image') !!}

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px;">
                                    </div>
                                    <div>
                                                       <span class="btn default btn-file">
                                                       <span class="fileinput-new">
                                                       {{trans('core.changeImage')}} </span>
                                                       <span class="fileinput-exists">
                                                       {{trans('core.change')}} </span>
                                                       <input type="file" name="logo">
                                                       </span>
                                        <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                                            {{trans('core.remove')}} </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                                        <span class="label label-danger">
                                                        NOTE!</span> Image Size must be height 40px

                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.companyName')}}: <span class="required">
                                        * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_name" placeholder="Website Title"
                                       value="{{Input::old('company_name')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.companyAddress')}}:
                            </label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="address"
                                          placeholder="Company Address">{{Input::old('address')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Country</label>
                            <div class="col-md-6">
                                <select class="select2me form-control" data-show-subtext="true" name="country">
                                    @foreach($countrieslist as $country)
                                        <option value="{{$country->name}}">{{$country->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.phone')}}:
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="contact"
                                       value="{{Input::old('contact')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Name: <span class="required">  * </span></label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Name"
                                       value="{{Input::old('name')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.email')}}: <span class="required">
                                            * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{Input::old('email')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.password')}}: <span class="required">
                                            * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="password">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-2">Currency</label>
                            <div class="col-md-6">
                                <select class="select2me form-control" data-show-subtext="true" name="currency">
                                    @foreach($countries as $country)
                                        <option value="{{$country->currency_symbol}}:{{$country->currency_code}}">{{$country->currency_code}} {{$country->currency_symbol}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <!------------------------- END FORM ----------------------->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="button" onclick="companyCreate();return false;"

                                        class="btn green">{{trans('core.btnSubmit')}}</button>

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
            {!! HTML::script("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js")  !!}
            {!! HTML::script('assets/global/plugins/bootstrap-select/bootstrap-select.min.js')  !!}

            {!! HTML::script('assets/global/plugins/select2/js/select2.min.js')  !!}
            {!! HTML::script('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')  !!}
            {!! HTML::script('assets/admin/pages/scripts/components-dropdowns.js')  !!}



            <script>
                jQuery(document).ready(function () {
                    $.fn.select2.defaults.set("theme", "bootstrap");
                    $('.select2me').select2({
                        placeholder: "Select",
                        width: '100%',
                        allowClear: false
                    });
                    ComponentsDropdowns.init();
                });

                function companyCreate() {
                    var url = "{{ route('admin.companies.store') }}";
                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        container: '.ajax_form',
                        file: true,
                    });
                }
            </script>
            <!-- END PAGE LEVEL PLUGINS -->
@stop
