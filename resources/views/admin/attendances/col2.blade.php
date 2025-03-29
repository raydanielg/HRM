<input type="checkbox"
       id="checkbox{{  $row->employeeID }}"
       onchange="showHide('{{ $row->employeeID }}');return false;"
       class="make-bs-switch md-check"
       data-size="small" name="checkbox[]"
       data-on-color="success" data-on-text="P" data-off-text="A"
       data-off-color="danger"
       @if($row->status == "present" || $row->date == null) checked @endif/>
<input type="hidden" name="employees[]" value="{{ $row->employeeID }}">

<div class="leave-form @if($row->status == "present" || $row->status == null) hidden @endif"
     id="leaveForm{{  $row->employeeID }}">
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <label class="control-label">Leave Type</label>
            <select class="form-control leaveType input-sm"
                    onchange="halfDayToggle({{  $row->employeeID }}, this.value)" id="leaveType{{  $row->employeeID }}"
                    name="leaveType[]">
                @foreach($leaveTypes as $leaveType)
                    <option @if($row->leaveType == $leaveType) selected @endif>{{ $leaveType }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6 col-md-12">
            <p class="hidden-md"></p>
            <label class="control-label"><input type="checkbox" id="halfDay{{  $row->employeeID }}"
                                                @if($row->halfDayType == "yes") checked @endif name="half_day[]"
                                                class="half-day-checkbox"/> Half Day</label>
        </div>
        <div class="col-lg-12">
            <label class="control-label">Reason</label>
            <input type="text" class="form-control reason input-sm" id="reason{{  $row->employeeID }}" name="reason[]"
                   placeholder="@lang("core.absentReason")" value="{{ $row->reason }}">
        </div>
    </div>
</div>
