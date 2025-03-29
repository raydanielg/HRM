@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!!  HTML::style("assets/global/plugins/icheck/skins/all.css")  !!}

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
                <i class="fa fa-home"></i>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.settings.edit','setting') }}')">Settings</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href=""> Setting</a>
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
                        <i class="fa fa-cogs font-dark"></i>Admin Panel Theme
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::model($setting, ['method' => 'PATCH','files' => true, 'route' => ['admin.settings.update', $setting->id],'class'=>'horizontal-form'])  !!}


                    <div class="form-group" style="padding-top: 15px;">
                        <label class="control-label col-md-4">Select Theme</label>
                        <div class="col-md-6">
                            <div class="icheck-list">
                                <label>
                                    <label><input type="radio" name="admin_theme"
                                                  @if($setting->admin_theme=='default') checked @endif class="icheck"
                                                  value="default"> Default <span class="btn blue-ebonyclay"></span>
                                    </label><br>
                                    <label><input type="radio" name="admin_theme"
                                                  @if($setting->admin_theme=='light') checked @endif class="icheck"
                                                  value="light"> Light <span class="btn"
                                                                             style="background-color: white;"></span></label>
                                </label>
                            </div>

                        </div>

                        <div class="">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-12 margin-top-10">
                                    <button type="submit" data-loading-text="Updating..."
                                            class="btn green"><i class="fa fa-check"></i> Submit
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close()  !!}
                <!------------------------- END FORM ----------------------->

                    <div id="admin_image" style="padding: 10px;text-align: center">
                        {!! HTML::image("assets/theme_images/admin/$setting->admin_theme.png",'Logo',array('class'=>'logo-default img-responsive','height'=>'300px','style'=>'margin: 0 auto;')) !!}
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
        <!-- END PAGE CONTENT-->

    </div>

@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->

    {!!  HTML::script('assets/admin/pages/scripts/components-dropdowns.js')  !!}
    {!!  HTML::script('assets/global/plugins/icheck/icheck.min.js')  !!}




    <script>
        jQuery(document).ready(function () {

            ComponentsDropdowns.init();

        });

        $('input[name=admin_theme]').on('ifChecked', function (event) {
            $('#admin_image').html('<span class="fa fa-refresh fa-spin"></span>');
            var image = this.value + ".png";
            var image_url = '{!! HTML::image("assets/theme_images/admin/:image",'Logo',array('class'=>'logo-default img-responsive','height'=>'300px')) !!}';
            image_url = image_url.replace(':image', image);
            $('#admin_image').html(capitalizeFirstLetter(this.value) + " " + image_url);
        });

        $('input[name=front_theme]').on('ifChecked', function (event) {
            $('#front_image').html('<span class="fa fa-refresh fa-spin"></span>');
            var image = this.value + ".png";
            var image_url = '{!! HTML::image("assets/theme_images/front/:image",'Logo',array('class'=>'logo-default img-responsive','height'=>'300px')) !!}';
            image_url = image_url.replace(':image', image);
            $('#front_image').html(capitalizeFirstLetter(this.value) + " " + image_url);
        });

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
