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

                @if($setting->cron_job_set == 0)
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h5 class="text-white">Set following cron command on your server (This message will automatically get hide when first time cron job runs)</h5>
                            <code>* * * * * cd {{ base_path() }} && php artisan schedule:run >> /dev/null 2>&1</code>
                        </div>
                    </div>
                @endif
                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::model($setting, ['method' => 'PUT','files' => true,'class'=>'form-horizontal', 'id' => 'generalSettings'])  !!}

                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-2">{{trans('core.companyLogo')}}</label>
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">

                                        {!! HTML::image($setting->logo_image_url) !!}

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
                            <label class="col-md-2 control-label">Application Name: <span class="required">
                                        * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="main_name" placeholder="Website Title"
                                       value="{{ $setting->main_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.companyAddress')}}:
                            </label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="address"
                                          placeholder="Company Address">{{$setting->address}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.phone')}}:
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="contact" value="{{ $setting->contact }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.email')}}: <span class="required">
                                            * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{ $setting->email}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Name: <span class="required">  * </span></label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Name"
                                       value="{{ $setting->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">@lang("core.currency")</label>
                            <div class="col-md-6">
                                <select class="select2me form-control" data-show-subtext="true" name="currency">
                                    @foreach($countries as $country)
                                        <option value="{{$country->currency_symbol}}:{{$country->currency_code}}"
                                                @if($setting->currency==$country->currency_code) selected @endif>{{$country->currency_code}} {{$country->currency_symbol}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="abc">
                            <label class="col-md-2 control-label">Language: </label>
                            <div class="col-md-6">

                                <select class="select2me form-control" name="locale" id="select_lang">
                                    @foreach($languages as $lang)
                                        <option value="{{$lang->locale}}"
                                                @if($lang->locale == $setting->locale) selected="selected" @endif>{{$lang->language}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!------------------------- END FORM ----------------------->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="submit" onclick="updateSetting();return false;" data-loading-text="{{trans('core.btnUpdating')}}..."
                                        class="btn green">{{trans('core.btnUpdate')}}</button>

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



@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js") !!}
    {!! HTML::script('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') !!}

    {!! HTML::script('assets/global/plugins/select2/js/select2.min.js') !!}
    {!! HTML::script('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') !!}
    {!! HTML::script('assets/admin/pages/scripts/components-dropdowns.js') !!}



    <script>
        jQuery(document).ready(function () {
            $.fn.select2.defaults.set("theme", "bootstrap");
            $('.select2me').select2({
                placeholder: "Select",
                width: '100%',
                allowClear: false
            });

            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span><img src="{{ asset('assets/global/img/flags') }}/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            }
            $("#select_lang").select2({
                placeholder: "Select a Language",
                templateResult: formatState,
                templateSelection: formatState
            });
            ComponentsDropdowns.init();
        });

        function updateSetting() {
            var url = "{{ route('admin.settings.update', $setting->id) }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '#generalSettings',
                file: true,
            });
        }
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
