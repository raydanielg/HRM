@extends('admin.adminlayouts.adminlayout')

@section('head')


        <!-- BEGIN PAGE LEVEL STYLES -->
{!! HTML::style("assets/admin/pages/css/blog.min.css")!!}
{!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
{!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
        <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


        <!-- BEGIN PAGE HEADER-->
{{--<div class="page-head"><div class="page-title"><h1>--}}
            {{--{{ $update->title }}--}}
        {{--</h1></div></div>--}}
{{--<div class="page-bar">--}}
    {{--<ul class="page-breadcrumb breadcrumb">--}}
        {{--<li>--}}
            {{--<a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>--}}
            {{--<i class="fa fa-circle"></i>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a onclick="loadView('{{route('admin.updates.index')}}')">{{trans('pages.updates.indexTitle')}}</a>--}}
            {{--<i class="fa fa-circle"></i>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<span class="active">{{ $update->title }}</span>--}}
        {{--</li>--}}

    {{--</ul>--}}

{{--</div>--}}
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="blog-page blog-content-2">
    <div class="row">
        <div class="col-md-12">
            <div class="blog-single-content bordered blog-container">
                <div class="blog-single-head">
                    <h1 class="blog-single-head-title">{{ $update->title }}</h1>
                    <div class="blog-single-head-date">
                        <i class="icon-calendar font-blue"></i>
                        <a href="javascript:;">{{ $update->created_at->format("M d, Y") }}</a>
                    </div>
                </div>
                <div class="page-bar">
                    <ul class="page-breadcrumb breadcrumb" style="padding: 0px">
                        <li>
                            <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a onclick="loadView('{{route('admin.updates.index')}}')">{{trans('pages.updates.indexTitle')}}</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">{{ $update->title }}</span>
                        </li>

                    </ul>

                </div>
                <hr>
                <div class="blog-single-desc">
                    {!! $update->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->

{{--MODAL CALLING--}}
@include('admin.common.delete')
{{--MODAL CALLING END--}}
@stop



@section('footerjs')


<!-- BEGIN PAGE LEVEL PLUGINS -->
{!! HTML::script("assets/global/plugins/select2/js/select2.min.js") !!}
{!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js") !!}
{!! HTML::script("assets/global/plugins/datatables/datatables.min.js") !!}
{!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") !!}
<!-- END PAGE LEVEL PLUGINS -->

<script>

</script>
@stop
