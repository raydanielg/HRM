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
                    <div class="caption font-dark">
                        <i class="fa fa-file-image-o font-dark"></i>  {{$pageTitle}}
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body">


                    <table class="table table-striped table-bordered table-hover" id="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Company</th>
                            <th>Invoice No</th>
                            <th>Package</th>
                            <th>Transaction no</th>
                            <th>Amount ($)</th>
                            <th>Pay Date</th>
                            <th>Next Pay Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
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

    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}

    <script>

      var table =   $('#table').dataTable( {
            {!! $datatabble_lang !!}
            processing: true,
            serverSide: true,
            "aaSorting": [[7, "desc"]],
            "ajax": "{{ route("admin.ajax_invoices") }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'company', name: 'company.company_name'},
                { data: 'invoice_id', name: 'invoice_id' },
                { data: 'plan', name: 'plan.plan_name' },
                { data: 'transaction_id', name: 'transaction_id'},
                { data: 'amount', name: 'amount' },
                { data: 'pay_date', name: 'pay_date' },
                { data: 'next_pay_date', name: 'next_pay_date' }
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
    </script>
@stop
