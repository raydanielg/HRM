@extends('front.layouts.frontlayout')

@section('head')

    {{--{!! HTML::style("assets/global/css/components.css")!!}--}}
    {!! HTML::style("assets/global/css/plugins.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
@stop

@section('mainarea')
    <div class="col-md-9">
        <!--Profile Body-->
        <div class="profile-body">
            <div class="row margin-bottom-20">
                <!--Profile Post-->
                <div class="col-sm-12">


                    <div class="panel ">
                        <div class="panel-heading service-block-u">
                            <h3 class="panel-title"><i class="fa fa-tasks"></i> {{trans('core.mySalarySlip')}}</h3>
                        </div>
                        <div class="panel-body">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="payroll">
                                    <thead>
                                    <tr>
                                        <th> {{trans('core.id')}} </th>

                                        <th> {{trans('core.month')}} </th>
                                        <th> {{trans('core.year')}} </th>
                                        <th> {{trans('core.netSalary')}} {{$setting->currency_symbol}} </th>
                                        <th> {{trans('core.createdOn')}} </th>
                                        <th class="text-center"> {{trans('core.action')}} </th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr>
                                        <td>{{-- ID --}}</td>
                                        <td>{{-- Month --}}</td>
                                        <td>{{-- Year --}}</td>
                                        <td>{{-- Net --}}</td>
                                        <td>{{-- created On --}}</td>
                                        <td>{{-- Action --}} </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!--End Profile Post-->


                </div><!--/end row-->

                <hr>


            </div>
            <!--End Profile Body-->
        </div>

    </div>


    {{--------------------------Show Notice MODALS-----------------}}


    <div class="modal fade show_notice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 id="myLargeModalLabel" class="modal-title">
                        Salary Slip
                    </h4>
                </div>
                <div class="modal-body" id="modal-data">
                    {{--Notice full Description using Javascript--}}
                </div>
            </div>
        </div>
    </div>


    {{------------------------END Notice MODALS---------------------}}

@stop

@section('footerjs')

    {!!  HTML::script("assets/global/plugins/datatables/datatables.min.js") !!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}

    <script>

        var table = $('#payroll').dataTable({
            processing: true,
            serverSide: true,
            {!! $datatabble_lang !!}
            "ajax": "{{ URL::route("front.ajax_payrolls") }}",

            "columns": [
                {data: 'id', name: 'payrolls.id'},
                {data: 'month', name: 'month', searchable: true},
                {data: 'year', name: 'payrolls.year'},
                {data: 'net_salary', name: 'payrolls.net_salary'},
                {data: 'created_at', name: 'payrolls.created_at'},
                {data: 'actions', name: 'actions'}
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "sPaginationType": "full_numbers",
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            }

        });


        function show_salary_slip(id) {
            $('#modal-data').html('<div class="text-center">{!! HTML::image('front_assets/img/loader.gif') !!}</div>');
            $.ajax({
                type: "GET",
                url: "{!!  URL::to('panel/salary_slip/"+id+"')  !!}"

            }).done(function (response) {
                $('#modal-data').html(response);
//
            });
        }


    </script>


@stop
