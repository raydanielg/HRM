@extends('admin.adminlayouts.adminlayout')

@section('head')
{!!  HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
{!! HTML::style("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.css")!!}
    @stop


    @section('mainarea')

            <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{ trans('pages.employees.importTitle')}}
            </h1></div>
    </div>
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a onclick="loadView('{{route('admin.employees.index')}}')">{{ trans("pages.employees.indexTitle") }}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">{{ trans('pages.employees.importTitle')}}</span>
        </li>
    </ul>
    <!-- END PAGE HEADER-->

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div class="portlet light bordered" id="beforeSubmitting">
                <div class="portlet-title">
                    <div class="caption red-sunglo">
                        <i class="fa fa-close font-red-sunglo"></i> @lang('pages.employees.failedRecords')
                    </div>
                    <div class="actions">
                        <a href="{{ route("admin.employees.index") }}" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> <span class="hidden-xs">@lang("core.goBackToEmployees")</span></a>
                        <a href="{{ route("admin.employees.downloadFailedRecords") }}" class="btn btn-primary"><i class="fa fa-download"></i> <span class="hidden-xs">@lang("core.downloadFailedRecords")</span></a>
                    </div>
                </div>

                <div class="portlet-body form">
                    <form class="form-horizontal">
                        <div class="form-body">
                            <div class="alert alert-info"><strong>Info!</strong> Accounts of all employees have been
                                created. You should inform them to login with their <strong>email</strong> and
                                default password <strong>123456</strong>.
                            </div>
                            <p>@lang("messages.failedRecordsMessage")</p>
                            <div class="row">
                                <div class="col-sm-12" style="overflow-x: scroll;">
                                    <table class="table table-striped table-bordered table-hover responsive" id="failed_records_table">
                                        <thead>
                                            <tr>
                                                @foreach($csvHeading as $h)
                                                    <td>{{ $h }}</td>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($failedRecords as $record)
                                               <tr>
                                                   @foreach($record as $key => $cell)
                                                       {{--@if ($key != -1)--}}
                                                           @if($key == "failReason")
                                                                <td class="all">{{ $cell }}</td>
                                                           @else
                                                               <td>{{ $cell }}</td>
                                                           @endif
                                                       {{--@endif--}}
                                                   @endforeach
                                               </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("footerjs")
    {!!  HTML::script("assets/global/plugins/datatables/datatables.min.js") !!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") !!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/responsive/dataTables.responsive.js") !!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.js") !!}

    <script type="text/javascript">
        var table = $('#failed_records_table').dataTable({
            {!! $datatabble_lang !!}
            "bProcessing": true,
            "autoWidth": false,
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "sPaginationType": "full_numbers",
            "fnInitComplete": function() {
                $(".dataTables_length").addClass("hidden-xs");
                $(this).removeClass("hidden");
            }
        });
    </script>
@endsection