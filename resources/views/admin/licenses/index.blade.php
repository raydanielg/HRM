@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css") !!}
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


                    <table class="table table-striped table-bordered table-hover" id="table">
                        <thead>
                        <tr>
                            <th> License </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Company </th>
                            <th> SubDomain </th>
                            <th> License Type </th>
                            <th> Expires On </th>
                            <th> created at </th>
                            <th> status </th>
                            <th class="text-center"> {{trans('core.action')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($licensesDef as $row)
                            <tr>
                                <td>{{$row->license_number}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->company}}</td>
                                <td>{{$row->subdomain}}</td>
                                <td>{{$row->type}}</td>
                                <td>{{date('d-M-Y', strtotime($row->expires_on))}}</td>
                                <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
                                <td>@php($color = ['Valid' => 'success', 'Expired' => 'danger', 'Disabled' => 'warning',])
                                    <span id='status{{$row->license_number}}' class='label label-{{$color[$row->status]}}'>{{$row->status}}</span>
                                </td>
                                <td>
                                    <a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit('{{$row->license_number}}');return false;" ><i class="fa fa-edit"></i>{{trans('core.edit')}}</a>
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

{{--License Types--}}
<div id="static_license" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{$pageTitle}}</h4>
            </div>
            <div class="modal-body" id="license-form-body">
                {{--Ajax replace content--}}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>

            </div>
        </div>
    </div>
</div>

{{--END License Types--}}
@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->

    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") !!}
    {!! HTML::script("assets/admin/pages/scripts/components-pickers.js") !!}

    <script>

      var table =   $('#table').dataTable( {
            {!! $datatabble_lang !!}
            processing: true,
            serverSide: true,
            "aaSorting": [[7, "desc"]],
            "ajax": "{{ URL::route("admin.ajax_licenses") }}",
            "deferLoading":{{$total}},
            columns: [
                { data: 'license_number', name: 'license_number',"bSortable": false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'company', name: 'company' },
                { data: 'subdomain', name: 'subdomain' },
                { data: 'type', name: 'type' },
                { data: 'expires_on', name: 'expires_on' },
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


      function showEdit(license)
      {
          $('#static_license').modal('show');
          $("body").addClass("modal-open");
          var get_url = "{{ route('admin.licenses.edit',':license') }}";
          get_url = get_url.replace(':license',license);

          $("#license-form-body").html('<div class="text-center">{!!  HTML::image('assets/loader.gif') !!}</div>');

          $.ajax({
              type: "GET",
              url : get_url,
              data: {}
          }).done(function(response)
          {

              $("#license-form-body").html(response);
              ComponentsPickers.init();

          });
      }

      function updateData(license){
          var get_url = "{{ route('admin.licenses.update',':id') }}";
          get_url = get_url.replace(':id',license);
          $("#error_edit").html('<div class="alert alert-info">{{trans('messages.submitting')}}..</div>');
          $("#submitbutton_edit").prop('disabled', true);

          $.ajax({
              type: 'PUT',
              url: get_url,
              dataType: "JSON",
              data: $('#edit_form').serialize(),
              success: function(response) {
                  if(response.status == "error")
                  {
                      showToastrMessage('{{ __('messages.errorTitle') }}', '{{__('messages.error')}}', 'error');
                      $('#error').html('');
                      var arr = response.msg;
                      var alert ='';
                      $.each(arr, function(index, value)
                      {
                          if (value.length != 0)
                          {
                              alert += '<p><span class="fa fa-close"></span> '+ value+ '</p>';
                          }
                      });
                      $('#error_edit').html('<div class="alert alert-danger alert-dismissable"><button class="close" data-close="alert"></button> '+alert+'</div>');
                      $("#submitbutton_edit").prop('disabled', false);
                  }else{
                      $('#static_license').modal('hide');
                      $('#error').html('');
                      $("#submitbutton_edit").prop('disabled', false);
                      table._fnDraw();
                      showToastrMessage(response.msg, response.status, 'success');
                  }

              },
              error: function(xhr, textStatus, thrownError) {

              }
          });
      }
    </script>
@stop
