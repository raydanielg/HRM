@extends('admin.adminlayouts.adminlayout')

@section('head')
    {!!  HTML::style("assets/admin/pages/css/error.css")  !!}
    <!-- BEGIN THEME STYLES -->
@stop
@section('mainarea')
    <!-- BEGIN PAGE HEADER-->
    <div class="page-head"><div class="page-title"><h1>
        Not Authorised
    </h1></div></div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                                          <a href="{{ route('admin.dashboard.index') }}">{{ trans('core.home') }}</a>
                     <i class="fa fa-circle"></i>
                 </li>
            </ul>
    </div>
    <!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12 page-404">
        <div class="number">
           Access Denied!
        </div>

    </div>
</div>
@stop