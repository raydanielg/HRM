@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")!!}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.payroll.editTitle")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">@lang("core.dashboard")</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.payrolls.index') }}')">@lang("pages.payroll.indexTitle")</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("pages.payroll.editTitle")</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    {!! Form::open(['class'=>'form-horizontal','method'=>'POST','id'=>'salary-form']) !!}
    <div class="row">
        {{--Employee info--}}
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            {{--INLCUDE ERROR MESSAGE BOX--}}
            <div id="error"></div>
            {{--END ERROR MESSAGE BOX--}}

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        @lang('core.employeeInfo')
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-md-9">


                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-md-9">
                                    {!!  HTML::image($payroll->employee->profile_image_url,'ProfileImage',['height'=>'100px'])  !!}

                                    {{--Hidden Values--}}
                                    <input type="hidden" value="{{$payroll->employee->id}}" name="employee_id">
                                    <input type="hidden" value="{{$payroll->month}}" name="month">
                                    <input type="hidden" value="{{$payroll->year}}" name="year">
                                    {{--Hidden values--}}

                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-md-9">
                                    <ul>
                                        <li><h4>@lang("core.employeeID"): {{ $payroll->employee->employeeID}}</h4></li>
                                        <li><h4>@lang("core.name"): {{$payroll->employee->full_name}}</h4></li>
                                        <li><h4>@lang("core.month")
                                                : {!! date('F', strtotime($payroll->month . '01')) !!}</h4></li>
                                        <li><h4>@lang("core.year"): {{$payroll->year}}</h4></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-md-9">

                                </div>

                            </div>
                        </div>

                        <!--/span-->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        @lang("core.salaryInfo")
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.hourlyRate")</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control only-num" id="hourly_rate" name="hourly_rate"
                                   placeholder="@lang("core.hourlyRate")" value="{{ $hourly_rate }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.hoursClocked")</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control only-num" id="overtime_hours" name="overtime_hours"
                                   placeholder="@lang("core.hoursClocked")" value="{{$payroll->overtime_hours}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.totalHoursPayment")
                            ({{$loggedAdmin->company->currency_symbol}})</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control only-num" id="overtime_pay" name="overtime_pay"
                                   placeholder="overtime_pay" value="{{$payroll->overtime_pay}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.basicSalary")
                            ({{$loggedAdmin->company->currency_symbol}})</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control only-num" id="basic" name="basic"
                                   placeholder="@lang("core.basicSalary")" value="{{$payroll->basic}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.expenseClaim")
                            ({{$loggedAdmin->company->currency_symbol}})</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control only-num" id="expense_claim" name="expense"
                                   placeholder="@lang("core.expenseClaim")" value="{{$payroll->expense}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.status")</label>

                        <div class="col-md-7 margin-bottom-10">
                            <select class="form-control select2me" name="status">
                                <option value="paid" @if($payroll->status == 'paid') selected @endif>Paid</option>
                                <option value="unpaid" @if($payroll->status == 'unpaid') selected @endif>Unpaid</option>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                </div>

            </div>
        </div>
        {{--Allowances--}}
        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        @lang("core.editAllowances")
                    </div>
                </div>
                <div class="portlet-body">
                    {!! '';$i=0; !!}
                    @foreach(json_decode($payroll->allowances) as $index=>$value)

                        <div class="form-group" id="allowance{{$i}}">
                            <label class="control-label col-md-2"></label>
                            <div class="col-md-4 margin-bottom-10">
                                <input type="text" class="form-control" name="allowanceTitle[]" value="{{$index}}"
                                       placeholder="@lang("core.allowance") {{ $i + 1 }}">
                            </div>
                            <div class="col-md-3  margin-bottom-10">
                                <input type="text" class="allowance form-control" placeholder="@lang("core.value")"
                                       name="allowance[]" value="{{$value}}">
                            </div>
                            <label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label>
                            @if($i>0)
                                <div class="col-md-2">
                                    <button type="button" onclick="$('#allowance{{$i}}').remove();calculation();"
                                            class="btn red btn-sm delete">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                            @endif
                            {!! '';$i++; !!}
                        </div>
                    @endforeach


                    <div id="insertBeforeA"></div>
                    <div class="form-group">
                        <div class="col-md-12  margin-bottom-10 text-center">
                            <button type="button" id="plusButtonA" class="btn btn-sm green form-control-inline">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        {{--Allowances End--}}
        {{--Deductions--}}
        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        @lang("core.editDeductions")
                    </div>
                </div>
                <div class="portlet-body">
                    {!! '';$i=0; !!}
                    @foreach(json_decode($payroll->deductions) as $index=>$value)

                        <div class="form-group" id="deduction{{$i}}">
                            <label class="control-label col-md-2"></label>
                            <div class="col-md-4 margin-bottom-10">
                                <input type="text" class="form-control" name="deductionTitle[]" value="{{$index}}"
                                       placeholder="@lang("core.deduction") {{ $i + 1 }}">
                            </div>
                            <div class="col-md-3  margin-bottom-10">
                                <input type="text" class="deduction form-control" name="deduction[]" value="{{$value}}"
                                       placeholder="@lang("core.value")">
                            </div>
                            <label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label>
                            @if($i>0)
                                <div class="col-md-2">
                                    <button type="button" onclick="$('#deduction{{$i}}').remove();calculation();"
                                            class="btn red btn-sm delete">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                            @endif
                            {!! '';$i++; !!}
                        </div>
                    @endforeach


                    <div id="insertBeforeD"></div>
                    <div class="form-group">
                        <div class="col-md-12  margin-bottom-10 text-center">
                            <button type="button" id="plusButtonD" class="btn btn-sm green form-control-inline">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{--Deductions End--}}
        {{--Gross--}}
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        @lang("core.grossSalary")
                    </div>
                </div>
                <div class="portlet-body">


                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.totalAllowances")
                            ({{$loggedAdmin->company->currency_symbol}})</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control" id="total_allowance" name="total_allowance"
                                   placeholder="@lang("core.total")" value="{{$payroll->total_allowance}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.totalDeductions")
                            ({{$loggedAdmin->company->currency_symbol}})</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control" id="total_deduction" name="total_deduction"
                                   placeholder="@lang("core.total")" value="{{$payroll->total_deduction}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">@lang("core.netSalary")
                            ({{$loggedAdmin->company->currency_symbol}})</label>
                        <div class="col-md-7 margin-bottom-10">
                            <input type="text" class="form-control" id="net_salary" name="net_salary"
                                   placeholder="@lang("core.total")" value="{{round($payroll->net_salary, 2)}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--Gross End--}}
        <div class="col-md-12 text-center">
            <div class="portlet light bordered">
                <div class="portlet-body">

                    <button type="button" class="btn green"
                            onclick="submitData();return false;">@lang("core.btnSubmit")</button>
                </div>
            </div>

        </div>


    </div>

    {!!  Form::close()  !!}
    <!-- END FORM-->




    {{--Confirm Box Model--}}
    <div id="confirmBox" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">@lang("core.confirmation")"</h4>
                </div>
                <div class="modal-body" id="info">
                    <p>
                        {{--Confirm Message Here from Javascript--}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">@lang("core.cancel")</button>
                    <button type="button" data-dismiss="modal" class="btn green" id="show"><i
                                class="fa fa-edit"></i> @lang("core.modify")</button>
                </div>
            </div>
        </div>
    </div>

    {{--Confirm Box MODAL--}}
    <!-- END PAGE CONTENT-->

@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js")!!}
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")!!}
    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        onlyNum('only-num');
        var $insertBeforeA = $('#insertBeforeA');
        var i = $(".allowance").length;
        $('#plusButtonA').click(function () {
            i = $(".allowance").length;
            $('<div class="form-group" id="allowance' + i + '">' +
                '<div class="control-label col-md-2"></div>' +
                '<div class="col-md-4 margin-bottom-10">' +
                '<input type="text" class="form-control" name="allowanceTitle[]" placeholder="@lang("core.allowance") ' + i + '">' +
                '</div>' +
                '<div class="col-md-3  margin-bottom-10">' +
                '<input type="text" class="allowance form-control" name="allowance[]" placeholder="@lang("core.value")">' +
                '</div>' +
                '<label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label> ' +
                ' <div class="col-md-2"> <button type="button" onclick="$(\'#allowance' + i + '\').remove();" class="btn red btn-sm delete">' +
                '<i class="fa fa-close"></i>' +
                '</button></div>' +
                '</div>').insertBefore($insertBeforeA);
            onlyNum('allowance');

        });
        var $insertBeforeD = $('#insertBeforeD');
        var j = $(".deduction").length;
        $('#plusButtonD').click(function () {
            j = $(".deduction").length;
            $('<div class="form-group" id="deduction' + j + '">' +
                '<div class="control-label col-md-2"></div>' +
                '<div class="col-md-4 margin-bottom-10">' +
                '<input type="text" class="form-control" name="deductionTitle[]" placeholder="@lang("core.deduction") ' + j + '">' +
                '</div>' +
                '<div class="col-md-3  margin-bottom-10">' +
                '<input type="text" class="deduction form-control" name="deduction[]" placeholder="@lang("core.value")">' +
                '</div>' +
                '<label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label> ' +
                '<div class="col-md-2"> <button type="button" onclick="$(\'#deduction' + j + '\').remove();" class="btn red btn-sm delete">' +
                '<i class="fa fa-close"></i>' +
                '</button></div>' +
                '</div>').insertBefore($insertBeforeD);
            onlyNum('deduction');

        });
        onlyNum('allowance');
        onlyNum('deduction');

        function check() {
            $('#load').html();
            var employee_id = $('#employeeID').val();
            var month = $('#month').val();
            var year = $('#year').val();
            $.ajax({
                type: 'POST',
                url: "{{route('admin.payrolls.check')}}",
                dataType: "JSON",
                data: {'employee_id': employee_id, 'month': month, 'year': year},
                success: function (response) {
                    if (response.success == 'fail') {
                        $('#load').html(response.content);
                    } else {
                        $('#confirmBox').appendTo("body").modal('show');
                        $("#deleteModal").find('#info').html('Salary Slip for the selected employee month and year already created.Do you want modify it?');
                        $("#show").click(function () {
                            $('#load').html(response.content);
                            $('#load').append('<input type="hidden" name="type" value="edit">');
                        })
                    }

                },
                error: function (xhr, textStatus, thrownError) {

                }
            });
        }

        function submitData() {
            $('#error').html('<div class="alert alert-info"><span class="fa fa-info"></span> Submitting..</div>');
            $.ajax({
                type: 'POST',
                url: "{{route('admin.payrolls.store')}}",
                dataType: "JSON",
                data: $('#salary-form').serialize(),
                success: function (response) {
                    if (response.status == "error") {
                        $('#error').html('');
                        var arr = response.msg;
                        var alert = '';
                        $.each(arr, function (index, value) {
                            if (value.length != 0) {
                                alert += '<p><span class="fa fa-close"></span> ' + value + '</p>';
                            }
                        });

                        $('#error').append('<div class="alert alert-danger alert-dismissable"><button class="close" data-close="alert"></button> ' + alert + '</div>');
                        $("html, body").animate({scrollTop: 0}, "slow");
                    } else {
                        window.location.href = '{{route('admin.payrolls.index')}}'
                    }

                },
                error: function (xhr, textStatus, thrownError) {

                }
            });
        }

        $(document).on("change keydown paste input", function () {
            calculation();
        });

        function calculation() {
            var allowance = 0.0;
            var hours = 0;
            var hourly_rate = 0.0;
            var deduc = 0.0;
            var basic = 0.0;
            var expense_claim = 0.0;
            var overtime = 0.0;
            basic = $("#basic").val();
            expense_claim = $("#expense_claim").val();

            hourly_rate = $("#hourly_rate").val();
            hours = $("#overtime_hours").val();

            $("#overtime_pay").val(hourly_rate * hours);

            overtime = $("#overtime_pay").val();

            $(".allowance").each(function () {
                if ($(this).val() !== "") {
                    allowance += parseFloat($(this).val());
                }
            });

            $(".deduction").each(function () {
                if ($(this).val() !== "") {
                    deduc += parseFloat($(this).val());
                }

            });

            $("#total_allowance").val(allowance.toFixed(2));
            $("#total_deduction").val(deduc.toFixed(2));

            net_salary = (allowance - deduc) + parseFloat(basic) + parseFloat(overtime) + parseFloat(expense_claim);
            $("#net_salary").val(net_salary.toFixed(2));

        }

    </script>
@stop
