@extends('admin.adminlayouts.adminlayout')

@section('head')

<!-- BEGIN PAGE LEVEL STYLES -->
{!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
<!-- END PAGE LEVEL STYLES -->

@stop

@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head"><div class="page-title"><h1>
        {{$pageTitle}}
    </h1></div></div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                                          <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.home') }}</a>
                     <i class="fa fa-circle"></i>
                 </li>
            <li>
                <a href="#"> {{$pageTitle}}</a>

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
                <div class="portlet-title">

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">

                                <a class="btn green" data-toggle="modal" href="{{URL::route('admin.referral_members.create')}}">
                                        {{__('core.addReferral')}}
                                    <i class="fa fa-plus"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">


                    <table class="table table-striped table-bordered table-hover" id="referrals">
                        <thead>
                        <tr>
                            <th> Id. </th>
                            <th> Referral Code </th>
                            <th> Email </th>
                            <th> Name </th>
                            <th> Company Name </th>
                            <th> Position </th>
                            <th> Date of Agreement </th>
                            <th> Created at </th>
                            <th>Status</th>
                            <th class="text-center"> {{trans('core.action')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($referralDef as $row)
                            <tr >
                                <td>{{$row->id}}</td>
                                <td>{{$row->referral_code}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->company_name}}</td>
                                <td>{{$row->position}}</td>
                                <td>{{date('d-M-Y', strtotime($row->date_of_agreement))}}</td>
                                <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
                                <td>
                                    @php($color = ['active' => 'success', 'inactive' => 'danger'])
                                    <span id='status{{$row->id}}' class='label label-{{$color[$row->status]}}' >{{trans("core." . $row->status)}}</span>
                                </td>
                                <td>
                                    @if($row->status == 'active')
                                        @php($r_status = 'Disable')
                                        @php($color = 'blue-ebonyclay')
                                        @php($icon = 'ban')
                                    @else
                                        @php($r_status = 'Enable')
                                        @php($color = 'green')
                                        @php($icon = 'check')
                                    @endif
                                        <a  class="btn purple btn-sm margin-bottom-5"  href="{{route('admin.referral_members.edit', $row->id)}}" >
                                                        <i class="fa fa-edit"></i> {{trans("core.btnViewEdit") }}
                                                      </a>
                                                      <a  style="width: 94px" href="javascript:;" onclick="del('{{$row->id}}',' {{$row->referral_code}}');return false;" class="btn red btn-sm margin-bottom-10">
                                                                <i class="fa fa-trash"></i> {{ trans("core.btnDelete")}}</a>
                                                        <a  href="javascript:;" onclick="changeStatus({{$row->id}});return false;" class="btn {{$color}} btn-sm margin-bottom-10">
                                                                 <i class="fa fa-{{$icon}}"></i> {{$r_status}}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
<script>

  var table =   $('#referrals').dataTable( {
        processing: true,
        serverSide: true,
        {!! $datatabble_lang !!}
        "ajax": "{{ URL::route("admin.referral_members.ajax_members") }}",
        "aaSorting": [[ 1, "asc" ]],
        "deferLoading":{{$total}},
        columns: [
            { data: 'id', name: 'id' },
            { data: 'referral_code', name: 'referral_code' },
            { data: 'email', name: 'email' },
            { data: 'name', name: 'name' },
            { data: 'company_name', name: 'company_name' },
            { data: 'position', name: 'position' },
            { data: 'date_of_agreement', name: 'date_of_agreement' },
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status' },
            { data: 'edit', name: 'edit', "bSortable": false  }
        ],
        "lengthMenu": [
            [5, 15, 20, -1],
            [5, 15, 20, "All"] // change per page values here
        ],
        "sPaginationType": "full_numbers",

    });

  function del(id, code) {

    $('#deleteModal').modal('show');

    var msg = prepareMessage("@lang("messages.referralDeleteConfirm")", ":code", code);

    $("#deleteModal").find('#info').html(msg);
    $('#deleteModal').find("#delete").off().click(function () {
        var url = "{{ route('admin.referral_members.destroy',':id') }}";
        url = url.replace(':id', id);
        $.ajax({

            type: "DELETE",
            url: url,
            dataType: 'json',
            data: {"id": id}

        }).done(function (response) {

            if (response.success == "deleted") {
                $('#deleteModal').modal('hide');
                $('#row' + id).fadeOut(500);
                table._fnDraw();
                showToastrMessage(prepareMessage("@lang("messages.referralDeleteMessage")", ":code", code), '{{__('core.success')}}', 'success');

            }
        });
    })

}
function changeStatus(id){

    var url = "{{ route('admin.referral_members.change_status') }}";
    $.ajax({

        type: "POST",
        url: url,
        dataType: 'json',
        data: {"id": id}

    }).done(function (response) {
        table._fnDraw();
        showResponseMessage(response, "error");
    });
}
@if(Session::has('toastrHeading') && Session::has('toastrMessage'))
showToastrMessage("{{ Session::get('toastrMessage') }}", "{{ Session::get('toastrHeading') }}");
@endif
</script>
@stop
