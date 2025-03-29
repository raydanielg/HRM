<meta charset="utf-8"/>
<title>{!! $pageTitle !!} - {{ $loggedAdmin->company->company_name ?? $setting->main_name}} </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
{!! HTML::script("assets/global/plugins/pace/pace.min.js", array("rel" => "core"))!!}
{!! HTML::style("assets/global/plugins/pace/themes/pace-theme-flash.css", array("name" => "core"))!!}
{!! HTML::style("https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all", array("name" => "core"))!!}
{!! HTML::style("assets/global/plugins/font-awesome/css/font-awesome.min.css", array("name" => "core"))!!}
{!! HTML::style("assets/global/plugins/simple-line-icons/simple-line-icons.min.css", array("name" => "core"))!!}
{!! HTML::style("assets/global/plugins/bootstrap/css/bootstrap.min.css", array("name" => "core"))!!}
{!! HTML::style("assets/global/plugins/uniform/css/uniform.default.css", array("name" => "core"))!!}
{!! HTML::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css", array("name" => "core"))!!}
{!! HTML::style("assets/global/plugins/select2/css/select2.css", array("name" => "core"))!!}
{!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css", array("name" => "core"))!!}
@yield('head')
{!! HTML::style("assets/global/css/components.css?v=1", array("name" => "core", "id" => "css_before_this"))!!}
{!! HTML::style("assets/global/css/plugins.css", array("name" => "core"))!!}
{!! HTML::style("assets/admin/layout/css/layout.css?v=2", array("name" => "core"))!!}
{{--{!! HTML::style("assets/admin/layout/css/themes/$setting->admin_theme.min.css", array("name" => "core"))!!}--}}
{!! HTML::style("assets/admin/layout/css/themes/light.min.css?v=2", array("name" => "core"))!!}
{!! HTML::style("assets/admin/layout/css/custom.css?v=2", array("name" => "core"))!!}
{!! HTML::style('assets/global/plugins/froiden-helper/helper.css?v=2', array("name" => "core")) !!}

