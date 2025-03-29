@extends('admin.adminlayouts.adminlayout')

@section('head')

        <!-- BEGIN PAGE LEVEL STYLES -->
{!!  HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") !!}
        <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


        <!-- BEGIN PAGE HEADER-->
<div class="page-head"><div class="page-title"><h1>
            @lang("core.browse_history") - {{ $selected_company->company_name }}
        </h1></div></div>
<div class="page-bar">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.dashboard') }}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a onclick="loadView('{{ route('admin.companies.index') }}')">{{ trans('core.companies') }}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">@lang("core.browse_history")</span>
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

            <div class="portlet-body">

                <table class="table table-striped table-bordered table-hover" id="company">
                    <thead>
                        <tr>
                            <th> @lang("core.serialNo") </th>
                            <th> @lang("core.admin") </th>
                            <th> IP </th>
                            <th> URL </th>
                            <th> @lang("core.timeSpent") </th>
                            <th> @lang('core.createdOn') </th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>
<!-- END PAGE CONTENT-->
@stop



@section('footerjs')


        <!-- BEGIN PAGE LEVEL PLUGINS -->
{!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
{!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
{!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}

        <!-- END PAGE LEVEL PLUGINS -->

<script>


    var table = $('#company').dataTable( {
        {!! $datatabble_lang !!}
        "bProcessing": true,

        "bServerSide": true,
        "ajax": "{{ URL::route("admin.companies.ajax_browse_history", ["id" => $selected_company->id]) }}",
        "aaSorting": [[ 0, "desc" ]],
        "aoColumns": [
            { 'data': 'id',name: 'id', "bSortable": true  },
            { 'data': 'admin', name: 'admin', "bSortable": false },
            { 'data': 'ip',name: 'ip', "bSortable": true },
            { 'data': 'url',name: 'url', "bSortable": true },
            { 'data': 'time_spent',name: 'time_spent', "bSortable": true },
            { 'data': 'created_at',name: 'companies.created_at', "bSortable": true }
        ],
        "lengthMenu": [
            [5, 15, 20, -1],
            [5, 15, 20, "All"] // change per page values here
        ],

        "sPaginationType": "full_numbers",

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {

        }

    });

</script>
@stop
