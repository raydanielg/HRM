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
                    <div class="caption font-dark">
                        <i class="fa fa-certificate font-dark"></i>  {{$pageTitle}}
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body">


                    <table class="table table-striped table-bordered table-hover" id="emails">
                        <thead>
                        <tr>
                            <th> Id. </th>
                            <th> Payer ID </th>
                            <th> Email </th>
                            <th> Method </th>
                            <th> Name </th>
                            <th> Amount </th>
                            <th> created at </th>


                            <th class="text-center"> {{trans('core.action')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactionDef as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td>{{$row->payer_id}}</td>
                            <td>{{$row->payer_email}}</td>
                            <td>{{$row->payment_method}}</td>
                            <td>{{$row->payer_fname}}</td>
                            <td>{{$row->amount . " " . $row->currency_code}}</td>
                            <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
                            <td>
                                <a index  class="btn blue-ebonyclay btn-sm "  href="javascript:;" onclick="showView({{$row->id }});return false;" ><i class="fa fa-eye"></i> {{trans('core.btnView')}}</a>
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

{{-- Model--}}
<div id="showModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{$pageTitle}}</h4>
            </div>
            <div class="modal-body" id="show_info">
                {{--Ajax replace content--}}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>

            </div>
        </div>
    </div>
</div>

{{--ENDMODAL--}}
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
            "bProcessing": true,

            "bServerSide": true,
            "ajax": "{{ URL::route("admin.ajax_transactions") }}",
            "aaSorting": [[ 0, "desc" ]],
            "deferLoading":{{$total}},
            "aoColumns": [

                { 'sClass': 'center', "bSortable": true },
                { 'sClass': 'center', "bSortable": true },
                { 'sClass': 'center', "bSortable": true },
                { 'sClass': 'center', "bSortable": true },
                { 'sClass': 'center', "bSortable": true },
                { 'sClass': 'center', "bSortable": true },
                { 'sClass': 'center', "bSortable": true },
                { 'sClass': 'center', "bSortable": false }
            ],
            "iDisplayLength": 10,
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

            },
          "fnInitComplete": function(oSettings, json) {




          }

        });



      function showView(id){
          $('#showModal').appendTo("body").modal('show');
          var get_url = "{{ route('admin.transactions.show',':id') }}";
          get_url = get_url.replace(':id',id);

          $.ajax({
              type: 'GET',
              url: get_url,
              success: function(response) {
                  $('#show_info').html(response);
              },
              error: function(xhr, textStatus, thrownError) {

              }
          });
      }

    </script>
@stop
	