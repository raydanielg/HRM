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
            <div class="row">
                <!--Profile Post-->
                <div class="col-sm-12 margin-bottom-20">


                    <div class="panel">
                        <div class="panel-heading  service-block-u">
                            <h3 class="panel-title"><i class="fa fa-tasks"></i> {{trans('core.myLeaveApp')}}</h3>
                        </div>
                        <div class="panel-body">
                            {{------------------Error Messages----------}}
                            <div id="alert_message">
                                @if(Session::get('success_leave'))
                                    <div class="alert alert-success"><i
                                                class="fa fa-check"></i> {!! Session::get('success_leave') !!}</div>
                                @endif

                                @if (Session::get('error_leave'))
                                    <div class="alert alert-danger alert-dismissable ">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        @foreach (Session::get('error_leave') as $error)
                                            <p><strong><i class="fa fa-warning"></i></strong> {!!  $error  !!}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            {{------------------Error Messages----------}}
                            <table class="table table-striped table-bordered table-hover" id="applications">
                                <thead>
                                <tr>
                                    <th>{{trans('core.id')}}</th>
                                    <th>{{trans('core.date')}}</th>
                                    <th class="text-center">{{trans('core.days')}}</th>
                                    <th>{{trans('core.type')}}</th>

                                    <th>{{trans('core.reason')}}</th>
                                    <th>{{trans('core.appliedOn')}}</th>
                                    <th>{{trans('core.status')}}</th>
                                    <th>{{trans('core.action')}}</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> {{-- ID from Contoller ajaxload------}} </td>
                                    <td class="text-center"> {{-- Date from Contoller ajaxload----}} </td>
                                    <td> {{-- Days from Contoller ajaxload----}} </td>
                                    <td> {{-- Leavetype from Contoller ajaxload--}} </td>
                                    <td> {{-- Reason from Contoller ajaxload----}} </td>
                                    <td> {{-- Applied on from Contoller ajaxload---}} </td>
                                    <td> {{-- Status from Contoller ajaxload----}} </td>
                                    <td> {{-- Action from Contoller ajaxload----}} </td>
                                </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>


                    <!--End Profile Post-->


                </div><!--/end row-->


                <div class="col-sm-12 ">
                    <div class="panel panel-profile no-bg">
                        <div class="panel-heading overflow-h  service-block-u">
                            <h2 class="panel-title heading-sm pull-left">Leaves Left</h2>
                        </div>
                        <div class="panel-body panelHolder">
                            <table class="table table-light margin-bottom-0">
                                <tbody>
                                @foreach ($leaveTypesData as $leaveType)
                                    <tr>
                                        <td><span class="primary-link">{{  ucfirst($leaveType->leaveType) }}</span></td>
                                        @if (strtolower($leaveType->leaveType) == "annual")
                                            <td>{{ $employee->annual_leave }}</td>
                                        @elseif (($key = array_search($leaveType->leaveType, $takenLeaveTypes)) !== FALSE )
                                            <td>{{ $leaveType->num_of_leave - $takenLeaves[$key] }}</td>
                                        @else
                                            <td>{{ $leaveType->num_of_leave }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
            <!--End Profile Body-->
        </div>

    </div>


    {{--------------------------Show Notice MODALS-----------------}}


    <div class="modal fade show_notice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" id="modal-data">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>


    {{------------------------END Notice MODALS---------------------}}

@stop

@section('footerjs')
    {!!  HTML::script("assets/global/plugins/datatables/datatables.min.js") !!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}

    <script>

        var table = $('#applications').dataTable(
            {
                processing: true,
                serverSide: true,
                "ajax": "{{ URL::route("front.leave_applications") }}",
                "aaSorting": [[0, "asc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'days', name: 'days'},
                    {data: 'leaveType', name: 'leaveType'},
                    {data: 'reason', name: 'reason'},
                    {data: 'applied_on', name: 'applied_on'},
                    {data: 'application_status', name: 'application_status'},
                    {data: 'edit', name: 'edit', "bSortable": false}
                ],
                "sPaginationType": "full_numbers",
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "info": "Showing page _PAGE_ of _PAGES_",
                    "emptyTable": "{{trans('messages.noDataTable')}}",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "{{trans('core.search')}}:"
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var oSettings = this.fnSettings();
                    $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                    return nRow;
                }

            });


        function show_application(id) {
            var url = "{{ route('leaves.show',':id') }}";
            url = url.replace(':id', id);
            $.ajaxModal('#modal-data', url);
        }

        @if (Session::get('error_leave'))
        $("html, body").animate({scrollTop: $('#applications').height() + 600}, 2000);
        @endif


    </script>


@stop
