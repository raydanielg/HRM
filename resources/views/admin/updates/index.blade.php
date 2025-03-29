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
<div class="page-head"><div class="page-title"><h1>
            @lang("pages.updates.indexTitle")
        </h1></div></div>
<div class="page-bar">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">@lang("pages.updates.indexTitle")</span>
        </li>

    </ul>

</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">

        @foreach($updates as $update)
        <div class="blog-page blog-content-1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-post-lg bordered blog-container">
                        <div class="blog-post-content">
                            <h2 class="blog-title blog-post-title">
                                <a href="javascript:;" onclick="loadView('{{ route("admin.updates.show", ["id" => $update->id]) }}')">{{ $update->title }}</a> @if($update->admin_id == null && $loggedAdmin->type != "superadmin") <span class="badge badge-danger badge-roundless"> New </span> @endif
                            </h2>
                            <p class="blog-post-desc">{!! $update->excerpt !!}</p>

                            <div class="blog-post-foot">
                                @if($loggedAdmin->type == "superadmin")
                                <ul class="blog-post-tags">
                                    <li class="uppercase">
                                        <a href="javascript:;" onclick="loadView('{{ route("admin.updates.edit", ["id" => $update->id]) }}')"><i class="fa fa-edit"></i> @lang("core.edit")</a>
                                    </li>
                                    <li class="uppercase">
                                        <a href="javascript:;" onclick="del({{ $update->id }})"><i class="fa fa-times"></i>@lang("core.btnDelete")</a>
                                    </li>
                                </ul>
                                @endif
                                <div class="blog-post-meta">
                                    <i class="icon-calendar font-blue"></i>
                                    <a href="javascript:;">{{ $update->created_at->format("M d, Y") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="portlet light bordered">

            <div class="portlet-body">
                    <div class="row ">
                        @if($loggedAdmin->type == "superadmin")
                            <div class="col-md-6">
                                <a class="btn green margin-top-10" onclick="loadView('{{URL::route('admin.updates.create')}}')">
                                    {{trans('core.btnAddUpdate')}}
                                    <i class="fa fa-plus"></i> </a>
                            </div>
                        @endif
                        <div class="text-right col-md-6">
                            {!! $updates->render() !!}
                        </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>
<!-- END PAGE CONTENT-->

{{--MODAL CALLING--}}
@include('admin.common.delete')
{{--MODAL CALLING END--}}
@stop



@section('footerjs')


        <!-- BEGIN PAGE LEVEL PLUGINS -->
{!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
{!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
{!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
{!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}

        <!-- END PAGE LEVEL PLUGINS -->

<script>

    function del(id) {

        $('#deleteModal').modal('show');
        $("#deleteModal").find('#info').html('@lang("messages.updateDeleteConfirm")');
        $('#deleteModal').find("#delete").off().click(function () {
            var url = "{{ route('admin.updates.destroy',':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: "DELETE",
                url: url,
                dataType: 'json',
                data: {"id": id}

            }).done(function (response) {

                if (response.status == "success") {

                    $('#deleteModal').modal('hide');
                    $('#row' + id).fadeOut(500);
                    showToastrMessage('@lang("messages.updateDeleteMessage")', '{{__('core.success')}}', 'success');
                    loadView("{{ route( "admin.updates.index") }}");
                }
            });
        })

    }
</script>
@stop
