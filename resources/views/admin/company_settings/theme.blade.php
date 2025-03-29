@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css") !!}
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css") !!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css") !!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css") !!}
    {!! HTML::style("assets/global/plugins/icheck/skins/all.css") !!}

    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("core.themeSettings")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">@lang("core.dashboard")</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">{{trans('core.settings')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("core.themeSettings")</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <div id="load">

                {{--INLCUDE ERROR MESSAGE BOX--}}

                {{--END ERROR MESSAGE BOX--}}


            </div>
        </div>
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->


            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        @lang("core.frontEndTheme")
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::open( ['class'=>'horizontal-form ajax-form'])  !!}


                    <div class="form-group" style="padding-top: 15px;">
                        <label class="control-label col-md-2">Select Theme</label>
                        <div class="row">
                            <div class="col-md-4">

                                <div class="icheck-list">
                                    <label>
                                        <input type="radio" name="front_theme"
                                               @if($loggedAdmin->company->front_theme=='aqua') checked @endif class="icheck"
                                               value="aqua"> Aqua <span class="btn blue"></span></label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='dark-blue') checked
                                                  @endif class="icheck" value="dark-blue"> Dark-blue <span
                                                class="btn blue-steel"></span> </label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='default') checked
                                                  @endif class="icheck" value="default"> Default <span
                                                class="btn grey-cascade"></span> </label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='brown') checked
                                                  @endif class="icheck" value="brown"> Brown <span class="btn"
                                                                                                   style="background-color: saddlebrown;"></span></label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='dark-red') checked
                                                  @endif class="icheck" value="dark-red"> Dark-red <span class="btn"
                                                                                                         style="background-color: darkred;"></span></label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='light-green') checked
                                                  @endif class="icheck" value="light-green"> Light-green <span
                                                class="btn" style="background-color: lightgreen;"></span></label>

                                </div>

                            </div>
                            <div class="col-md-4">

                                <div class="icheck-list">
                                    <label>
                                        <input type="radio" name="front_theme"
                                               @if($loggedAdmin->company->front_theme=='light') checked @endif class="icheck"
                                               value="light"> Light <span class="btn"
                                                                          style="background-color: #95a5a6"></span></label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='orange') checked
                                                  @endif class="icheck" value="orange"> Orange <span class="btn"
                                                                                                     style="background-color: orangered"></span>
                                    </label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='purple') checked
                                                  @endif class="icheck" value="purple"> Purple <span class="btn"
                                                                                                     style="background-color: #800080;"></span>
                                    </label>

                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='red') checked @endif class="icheck"
                                                  value="red"> Red <span class="btn"
                                                                         style="background-color: red;"></span></label>
                                    <label><input type="radio" name="front_theme"
                                                  @if($loggedAdmin->company->front_theme=='teal') checked
                                                  @endif class="icheck" value="teal"> Teal <span class="btn"
                                                                                                 style="background-color: teal;"></span></label>

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-7 margin-top-20">
                                <button type="button" onclick="updateSetting();return false;"
                                        class="btn green">Submit
                                </button>

                            </div>
                        </div>

                        <!------------------------- END FORM ----------------------->

                    </div>
                    {!!  Form::close()  !!}
                    <div id="front_image"
                         style="padding: 10px;text-align: center">{{ucfirst($loggedAdmin->company->front_theme)}}
                        {!! HTML::image("assets/theme_images/front/".$loggedAdmin->company->front_theme.".png",'Logo',array('class'=>'logo-default img-responsive','height'=>'300px')) !!}
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>

        </div>

    </div>

@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js")  !!}
    {!! HTML::script('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')  !!}

    {!! HTML::script('assets/global/plugins/select2/js/select2.min.js')  !!}
    {!! HTML::script('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')  !!}
    {!! HTML::script('assets/admin/pages/scripts/components-dropdowns.js')  !!}
    {!! HTML::script('assets/global/plugins/icheck/icheck.min.js')  !!}




    <script>
        jQuery(document).ready(function () {

            ComponentsDropdowns.init();

        });


        $('input[name=front_theme]').on('ifChecked', function (event) {
            $('#front_image').html('<span class="fa fa-refresh fa-spin"></span>');

            var image = this.value + ".png";
            var image_url = '{!! HTML::image("assets/theme_images/front/:image",'Logo',
            array('class'=>'logo-default img-responsive','height'=>'300px')) !!}';
            image_url = image_url.replace(':image', image);
            $('#front_image').html(capitalizeFirstLetter(this.value) + " " + image_url);

        });

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function updateSetting() {
            $.easyAjax({
                type: 'POST',
                url: "{{ route('admin.company_setting.theme_update') }}",
                data: $(".ajax-form").serialize(),
                container: ".ajax-form",
            });
        }

    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
