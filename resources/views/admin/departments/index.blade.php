@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!!  HTML::style("assets/global/plugins/select2/css/select2.css") !!}
    {!!  HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')
    <div class="page-head">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-head">
            <div class="page-title"><h1>
                    {{ trans('pages.departments.indexTitle')}}
                </h1></div>

        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.dashboard') }}</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span class="active">{{trans('core.departments')}}</span>
            </li>

        </ul>

        <!-- END PAGE HEADER-->

        <div id="load">
            {{--INLCUDE ERROR MESSAGE BOX--}}

            {{--END ERROR MESSAGE BOX--}}
        </div>

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        @if($loggedAdmin->manager!=1)
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a class="btn green" onclick="showAdd();">
                                                {{ trans('core.btnAddDepartment') }}
                                                <i class="fa fa-plus"></i> </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        Sr No.
                                    </th>
                                    <th>
                                        {{trans('core.departmentName')}}
                                    </th>
                                    <th>
                                        {{trans('core.designations')}}
                                    </th>
                                    @if($loggedAdmin->manager!=1)
                                        <th>
                                            {{trans('core.actions')}}
                                        </th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                {{--@if(count($departments)>0)--}}
                                @forelse ($departments as $index=>$department)
                                    <tr id="row{{ $department->id }}">
                                        <td>
                                            {{ $index+1 }}
                                        </td>
                                        <td>
                                            {{ $department->name }}

                                        </td>

                                        <td>
                                            <ol>
                                                @foreach($department->designations as $desig)
                                                    <li>   {{ $desig->designation }}</li>

                                                @endforeach
                                            </ol>
                                        </td>
                                        @if($loggedAdmin->manager!=1)
                                            <td class=" ">
                                                <a class="btn purple btn-sm margin-bottom-10" data-toggle="modal"
                                                   href="#edit_static"
                                                   onclick="showEdit({{$department->id}},'{{ $department->name }}')"><i
                                                            class="fa fa-edit"></i> {{trans('core.btnViewEdit')}}</a>

                                                <a class="btn red btn-sm margin-bottom-10" style="width: 94px"
                                                   href="javascript:;"
                                                   onclick="del({{$department->id}},'{{ $department->name }}')"><i
                                                            class="fa fa-trash"></i> {{trans('core.btnDelete')}}</a>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center"> @lang('messages.noDeptTable')</td>
                                    </tr>
                                @endforelse
                                {{--@endif--}}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
        <!-- END PAGE CONTENT-->


        {{--------------------------EDIT MODALS-----------------}}

    </div>

    {{------------------------END EDIT MODALS---------------------}}


    {{--MODAL CALLING--}}
    @include('admin.common.delete')
    @include('admin.common.show-modal')
    {{--MODAL CALLING END--}}
@stop



@section('footerjs')

    <script>


        function addMore() {
            var $insertBefore = $('#insertBefore');
            var $i = $('.designation').length;
            $('<div class="form-group"><div><input class="form-control input-medium designation"  name="designation[' + $i + ']" type="text"  placeholder="{{trans('core.designation')}} #' + ($i + 1) + '"/></div></div>').insertBefore($insertBefore);
        }


        //-----EDIT Modal


        function addMoreEdit() {
            var $insertBefore_edit = $('#insertBefore_edit');
            var $j = $('.designation').length;
            $(' <div class="form-group" id="edit_field"><input class="form-control designation form-control-inline input-medium"  name="designation[' + $j + ']" type="text"  placeholder="{{trans('core.designation')}} #' + ($j + 1) + '"/></div>').insertBefore($insertBefore_edit);
        };

        function del(id, dept) {

            $('#deleteModal').modal('show');
            $("#deleteModal").find('#info').html('{!!  __('messages.departmentDeleteConfirm') !!} <strong>' + dept + '</strong>?<br>' +
                '<br><div class="note note-warning">' +
                '{!! __('messages.deleteNoteDepartment')!!}' +
                '</div>');

            $('#deleteModal').find("#delete").off().click(function () {
                var url = "{{ route('admin.departments.destroy',':id') }}";
                url = url.replace(':id', id);
                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'DELETE',
                    url: url,
                    data: {'_token': token},
                    container: "#deleteModal",
                    success: function (response) {
                        if (response.status === "success") {
                            $('#deleteModal').modal('hide');
                            table.fnDraw();
                        }
                    }
                });
            })

        }

        {{--function showEdit(id, name) {--}}

            {{--$('div[id^="edit_field"]').remove();--}}
            {{--var url = "{{ route('admin.departments.update',':id') }}";--}}
            {{--url = url.replace(':id', id);--}}
            {{--$('#edit_form').attr('action', url);--}}

            {{--var get_url = "{{ route('admin.departments.edit',':id') }}";--}}
            {{--get_url = get_url.replace(':id', id);--}}

            {{--$("#edit_name").val(name);--}}
            {{--$("#deptresponse").html('<div class="text-center">{!!  HTML::image('assets/loader.gif') !!}</div>');--}}

            {{--$.ajax({--}}

                {{--type: "GET",--}}
                {{--url: get_url,--}}

                {{--data: {"id": id}--}}

            {{--}).done(function (response) {--}}
                {{--$("#deptresponse").html(response);--}}
                {{--$j = $('input#designation').length - 1;--}}
            {{--});--}}

            {{--$('#edit_submit').click(function () {--}}
                {{--$("#error_edit").html('<div class="alert alert-info">{{trans('messages.submitting')}}..</div>');--}}
                {{--$("#edit_submit").prop('disabled', true);--}}

                {{--$.ajax({--}}
                    {{--type: 'POST',--}}
                    {{--url: url,--}}
                    {{--dataType: "JSON",--}}
                    {{--data: $('#edit_form').serialize(),--}}
                    {{--success: function (response) {--}}
                        {{--if (response.status == "error") {--}}
                            {{--showToastrMessage('{!!  __('messages.errorTitle')  !!}', '{!! __('messages.error') !!}', 'error');--}}
                            {{--$('#error_edit').html('');--}}
                            {{--var arr = response.msg;--}}
                            {{--var alert = '';--}}
                            {{--$.each(arr, function (index, value) {--}}
                                {{--if (value.length != 0) {--}}
                                    {{--alert += '<p><span class="fa fa-close"></span> ' + value + '</p>';--}}
                                {{--}--}}
                            {{--});--}}

                            {{--$('#error_edit').html('<div class="alert alert-danger alert-dismissable"><button class="close" data-close="alert"></button> ' + alert + '</div>');--}}
                            {{--$("#edit_submit").prop('disabled', false);--}}
                        {{--} else {--}}
                            {{--$('#edit_static').modal('hide');--}}
                            {{--loadView(response.url);--}}
                        {{--}--}}

                    {{--},--}}
                    {{--error: function (xhr, textStatus, thrownError) {--}}

                    {{--}--}}
                {{--})--}}
            {{--})--}}
        {{--}--}}

        function showEdit(id,name) {
            var url = "{{ route('admin.departments.edit',':id') }}";
            url = url.replace(':id', id);
            $.ajaxModal('#showModal', url);

        }

        function showAdd() {
            var url = "{{ route('admin.departments.create') }}";
            $.ajaxModal('#showModal', url);
            var $insertBefore = $('#insertBefore');
            var $i = 0;

        }

        function addSubmit() {
            $.easyAjax({
                type: 'POST',
                url: "{{route('admin.departments.store')}}",
                container: '.ajax_form',
                data: $('.ajax_form').serialize(),
                success: function (response) {
                    if (response.status === "success") {
                        $('#showModal').modal('hide');
                    }

                }
            });
        }

        function updateSubmit(id) {
            var url = "{{ route('admin.departments.update',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '.ajax_form',
                data: $('.ajax_form').serialize(),
                success: function (response) {
                    if (response.status === "success") {
                        $('#showModal').modal('hide');
                    }

                }
            });
        }
    </script>
@stop
