@extends('admin.adminlayouts.adminlayout')

@section('head')
{!!  HTML::style("assets/admin/pages/css/error.css")  !!}
        <!-- BEGIN THEME STYLES -->
@stop
@section('mainarea')
        <!-- BEGIN PAGE HEADER-->
<div class="page-head"><div class="page-title"><h1>
            Error!
        </h1></div></div>
<div class="page-bar">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard.index') }}">{{ trans('core.dashboard') }}</a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12 page-500">
        <div class=" number font-red"> 500 </div>
        <div class=" details">
            <h3>Oops! Something went wrong.</h3>
            <p><strong>{{ $message }}</strong></p>
            <p>
                <a href="{{ route("admin.dashboard.index") }}" class="btn red btn-outline"> Return to Dashboard </a>
                <br> </p>
        </div>
    </div>
</div>
@stop