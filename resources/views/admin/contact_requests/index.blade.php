@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-summernote/summernote.css")!!}
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
                <span class="active">Contact Requests</span>

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
                    <div class="caption font-dark">
                        <i class="fa fa-envelope font-dark"></i> Contact Request
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body">


                    <table class="table table-striped table-bordered table-hover" id="emails">
                        <thead>
                        <tr>
                            <th> Sr No. </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Category </th>
                            <th> Details </th>
                            <th> created at </th>
                            <th> status </th>

                            <th class="text-center"> {{trans('core.action')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($contactDef as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->category}}</td>
                                <td>{{$row->details}}</td>
                                <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
                                <td>
                                    @php($color = ['Pending' => 'warning', 'Completed' => 'success'])
                                    <span id='status{{$row->id}}' class='label label-{{$color[$row->status]}}'>{{$row->status}}</span>
                                </td>
                                <td>
                                    @if($row->status == 'Completed')
                                        <a data-container="body" data-placement="top" data-original-title="Pending" href="javascript:;" onclick="changeStatus('{{$row->id}}','Pending');return false;" class="btn yellow btn-sm tooltips"><i class="fa fa-close"></i> Pending</a>
                                    @elseif($row->status == 'Pending')
                                        <a  data-container="body" data-placement="top" data-original-title="Completed" href="javascript:;" onclick="changeStatus('{{$row->id}} ','Completed');return false;" class="btn green btn-sm tooltips"><i class="fa fa-check"></i> Completed</a>
                                    @endif
                                        <a  class="blue-ebonyclay btn btn-sm "  href="javascript:;" onclick="showView({{$row->id}});return false;" ><i class="fa fa-eye"></i> {{ trans('core.btnView')}}</a>
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

{{--Job  Model--}}
<div id="ContactModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{$pageTitle}}</h4>
            </div>
            <div class="modal-body" id="contact_info">
                {{--Ajax replace content--}}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>

            </div>
        </div>
    </div>
</div>

{{--END Job MODAL--}}
@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-summernote/summernote.min.js") !!}
    <script>
        $('#body').summernote({height: 300});
    </script>
    <!-- END PAGE LEVEL PLUGINS -->

    <script>


      var table =   $('#emails').dataTable( {
            {!! $datatabble_lang !!}
            processing: true,
          serverSide: true,
            "ajax": "{{ URL::route("admin.ajax_contact_requests") }}",
            "deferLoading":'{{$total}}',
          "aaSorting": [[ 0, "desc" ]],
            "columns": [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'category', name: 'category' },
                { data: 'details', name: 'details' },
                { data: 'created_at', name: 'created_at' },
                { data: 'status', name: 'status' },
                { data: 'edit', name: 'edit', "bSortable": false  }
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            },
          "fnInitComplete": function(oSettings, json) {

              App.init();


          }

        });



      function showView(id){
          $('#ContactModal').appendTo("body").modal('show');
          var get_url = "{{ route('admin.contact_requests.show',':id') }}";
          get_url = get_url.replace(':id',id);

          $.ajax({
              type: 'GET',
              url: get_url,

              data: {'id':id},
              success: function(response) {
                  $('#contact_info').html(response);
                  $('#body').summernote({height: 300});
              },
              error: function(xhr, textStatus, thrownError) {

              }
          });
      }
      function changeStatus(id,status){
          $.ajax({
              type: 'POST',
              url: "{{route('admin.contact_requests.change_status')}}",
              dataType: "JSON",
              data: { 'status':status,'id':id},
              success: function(response) {
                  table._fnDraw();
                  showToastrMessage(status, '{{__('messages.statusChanged')}}', 'success');

              },
              error: function(xhr, textStatus, thrownError) {

              }
          });
      }
    </script>
@stop
