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


                    {{------------------Error Messages----------}}
                    <div id="alert_message">
                        @if(Session::get('success'))
                            <div class="alert alert-success"><i class="fa fa-check"></i> {{ Session::get('success') }}
                            </div>
                        @endif
                    </div>
                    {{------------------Error Messages----------}}

                    <a href="{{route('front.expenses.create')}}" class="btn-u field"><i
                            class="fa fa-plus"></i> {{__('menu.addExpenseFront')}}</a>
                    <hr>
                    <div class="panel ">
                        <div class="panel-heading service-block-u">
                            <h3 class="panel-title">{{$setting->currency_symbol}} My Expenses</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="expenses">
                                    <thead>
                                    <tr>
                                        <th> {{trans('core.id')}}</th>
                                        <th> {{trans('core.item')}}</th>
                                        <th> {{trans('core.purchase_from')}} </th>
                                        <th> {{trans('core.date')}}</th>
                                        <th>{{trans('core.price')}} ( {{$setting->currency_symbol}} )</th>
                                        <th>Bill</th>
                                        <th>{{trans('core.status')}}</th>


                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr>
                                        <td>{{-- ID --}}</td>
                                        <td>{{-- Item Name --}}</td>
                                        <td>{{-- Purchase Date --}}</td>
                                        <td>{{-- Purchase Date --}}</td>
                                        <td>{{-- Purchase Date --}}</td>
                                        <td>{{-- Status --}}</td>
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
                        Leave Application
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

        var table = $('#expenses').dataTable({
            {!! $datatabble_lang !!}
            processing: true,
            serverSide: true,
            "ajax": "{!!  URL::route("front.ajax_expenses")  !!}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'item_name', name: 'item_name'},
                {data: 'purchase_from', name: 'purchase_from'},
                {data: 'purchase_date', name: 'purchase_date'},
                {data: 'price', name: 'price'},
                {data: 'bill', name: 'bill'},
                {data: 'status', name: 'status'},

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
                url: "{{ URL::to('salary_slip/"+id+"') }}"

            }).done(function (response) {
                $('#modal-data').html(response);
//
            });
        }


    </script>


@stop
