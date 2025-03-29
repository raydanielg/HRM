<div id="updateCell{{ $row->employeeID }}">
@if($row->date == null)
    <span class="label label-danger">Not Marked</span>
@else
    @if($row->application_status == "approved")
        <span class="label label-warning">On Leave</span>
    @else
        <span class="label label-success">Marked</span>
    @endif

    @if ($row->is_late == 1)
        &nbsp;<span class="label label-danger">Late</span>
    @endif

<div class="margin-top-10">
    <strong>Clock In IP:</strong> <a href="#" id="clock_in_ip{{ $row->employeeID  }}" class="form-edit" data-type="text"  data-container="body" data-original-title="Enter Clock In IP">{{ $row->clock_in_ip_address ?? "Not Set" }}</a><br/>
    <strong>Clock Out IP:</strong> <a href="#" id="clock_out_ip{{ $row->employeeID  }}" data-type="text"  class="form-edit"  data-container="body" data-original-title="Enter Clock Out IP">{{ $row->clock_out_ip_address ?? "Not Set" }}</a><br/>
    <strong>Working From:</strong> <a href="#" id="work{{ $row->employeeID  }}" data-type="text"  class="form-edit" data-container="body"  data-original-title="Enter Work From">{{ $row->working_from ?? "Office" }}</a><br/>
    <strong>Notes:</strong> <a href="#" id="notes{{ $row->employeeID  }}" data-type="text"  class="form-edit" data-container="body"  data-original-title="Enter Note">{{ $row->notes ?? "Not Set" }}</a><br/>
</div>

@endif
</div>
