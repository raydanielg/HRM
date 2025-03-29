<div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->

    {{--INLCUDE ERROR MESSAGE BOX--}}
    <div id="error"></div>
    {{--END ERROR MESSAGE BOX--}}

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-blue-steel">
                @lang("core.editSalaryInfo")
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
                           placeholder="@lang("core.hoursClocked")" value="{{$payrolls->overtime_hours}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">@lang("core.totalHoursPayment") ({{$loggedAdmin->company->currency_symbol}})</label>

                <div class="col-md-7 margin-bottom-10">
                    <input type="text" class="form-control only-num" id="overtime_pay" name="overtime_pay"
                           placeholder="overtime_pay" value="{{$payrolls->overtime_pay}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">@lang("core.basicSalary") ({{$loggedAdmin->company->currency_symbol}})</label>

                <div class="col-md-7 margin-bottom-10 only-num">
                    <input type="text" class="form-control" id="basic" name="basic" placeholder="@lang("core.basicSalary")"
                           value="{{$payrolls->basic}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">@lang("core.expenseClaim") ({{$loggedAdmin->company->currency_symbol}})</label>

                <div class="col-md-7 margin-bottom-10">
                    <input type="text" class="form-control only-num" id="expense_claim" name="expense"
                           placeholder="@lang("core.expenseClaim")" value="{{$payrolls->expense}}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">@lang("core.status") </label>

                <div class="col-md-7 margin-bottom-10">
                    <select class="form-control select2me" name="status">
                        <option value="paid" @if($payrolls->status == 'paid') selected @endif>Paid</option>
                        <option value="unpaid" @if($payrolls->status == 'unpaid') selected @endif>Unpaid</option>
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
            <div class="caption font-blue-steel">
                @lang("core.editAllowances")
            </div>
        </div>
        <div class="portlet-body">
            <?php $i = 0; ?>
            @foreach(json_decode($payrolls->allowances) as $index=>$value)

                <div class="form-group" id="allowance{{$i}}">
                    <label class="control-label col-md-2"></label>

                    <div class="col-md-4 margin-bottom-10">
                        <input type="text" class="form-control" name="allowanceTitle[]" placeholder="@lang("core.allowance") {{ $i + 1 }}"
                               value="{{$index}}">
                    </div>
                    <div class="col-md-3  margin-bottom-10">
                        <input type="text" class="allowance form-control" placeholder="@lang("core.value")" name="allowance[]"
                               value="{{$value}}">
                    </div>
                    <label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label>
                @if($i>0)
                        <div class="col-md-2">
                            <button type="button" onclick="$('#allowance{{$i}}').remove();"
                                    class="btn red btn-sm delete">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    @endif
                    <?php $i++; ?>
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
            <div class="caption font-blue-steel">
                @lang("core.editDeductions")
            </div>
        </div>
        <div class="portlet-body">
            <?php $i = 0; ?>
            @foreach(json_decode($payrolls->deductions) as $index=>$value)

                <div class="form-group" id="deduction{{$i}}">
                    <label class="control-label col-md-2"></label>

                    <div class="col-md-4 margin-bottom-10">
                        <input type="text" class="form-control" name="deductionTitle[]" value="{{$index}}" placeholder="@lang("core.deduction") {{ $i + 1 }}">
                    </div>
                    <div class="col-md-3  margin-bottom-10">
                        <input type="text" class="deduction form-control" name="deduction[]" value="{{$value}}" placeholder="@lang("core.value")">
                    </div>
                    <label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label>
                    @if($i>0)
                        <div class="col-md-2">
                            <button type="button" onclick="$('#deduction{{$i}}').remove();"
                                    class="btn red btn-sm delete">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    @endif
                    <?php $i++; ?>
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
            <div class="caption font-blue-steel">
                @lang("core.grossSalary")
            </div>
        </div>
        <div class="portlet-body">


            <div class="form-group">
                <label class="control-label col-md-2">@lang("core.totalAllowances") ({{$loggedAdmin->company->currency_symbol}})</label>

                <div class="col-md-8 margin-bottom-10">
                    <input type="text" class="form-control" id="total_allowance" name="total_allowance"
                           placeholder="@lang("core.total")" value="{{$payrolls->total_allowance}}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">@lang("core.totalDeductions") ({{$loggedAdmin->company->currency_symbol}})</label>

                <div class="col-md-8 margin-bottom-10">
                    <input type="text" class="form-control" id="total_deduction" name="total_deduction"
                           placeholder="@lang("core.total")" value="{{$payrolls->total_deduction}}" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">@lang("core.netSalary") ({{$loggedAdmin->company->currency_symbol}})</label>

                <div class="col-md-8 margin-bottom-10">
                    <input type="text" class="form-control" id="net_salary" name="net_salary" placeholder="@lang("core.total")"
                           value="{{$payrolls->net_salary}}" readonly>
                </div>
            </div>
        </div>
    </div>
</div>
{{--Gross End--}}
<div class="col-md-12 text-center margin-bottom-30">
    <div class="portlet light bordered">
        <div class="portlet-body">
            <button type="button" class="btn green"
                    onclick="submitData();return false;">@lang("core.btnSubmit")</button>

        </div>
    </div>
</div>
