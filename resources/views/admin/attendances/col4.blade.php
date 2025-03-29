<div class="row">
    <div class="col-lg-6 col-md-12">
        <label class="control-label">Clock In</label>

        <div class="input-icon input-icon-sm">
            <i class="fa fa-clock-o"></i>
            <input type="text" class="form-control timepicker clockin input-sm" id="clock_in{{ $row->employeeID }}"
                   name="clock_in[]" value="{{ $clock_in }}"/>
        </div>
    </div>
    <div class="col-lg-6 col-md-12"><label class="control-label">Clock Out</label>
        <div class="input-icon input-icon-sm"><i class="fa fa-clock-o"></i>
            <input type="text" class="form-control timepicker clockout input-sm" id="clock_out{{$row->employeeID }}"
                   name="clock_out[]" value="{{ $clock_out }}"/>
        </div>
    </div>
    <div class="col-lg-12">
        <label class="control-label"><input type="checkbox" class="form-control late_checkbox"
                                            id="late{{ $row->employeeID }}" @if($row->is_late == 1) checked
                                            @endif name="late[]"/> Late</label>
    </div>
</div>