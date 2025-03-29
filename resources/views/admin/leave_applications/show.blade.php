<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <span class="caption-subject font-red-sunglo bold uppercase">{{ trans("core.leaveApplication") }}</span>
    </div>
    <div class="modal-body">
        <div class="portlet-body form">
            <div class="row">
                <label class="control-label col-md-3"><strong>@lang("core.name")</strong></label>
                <div class="col-md-9">
                    {{$leave_application->employee->full_name}}
                </div>
            </div>
            <br>
            <div class="row">
                <label class="control-label col-md-3"><strong>@lang("core.leaveType")</strong></label>
                <div class="col-md-9">
                    @if($leave_application->leaveType == 'half day')
                        {{ucfirst($leave_application->leaveType)}} - {{$leave_application->halfDayType}}
                    @else
                        {{ucfirst($leave_application->leaveType)}}
                    @endif
                </div>
            </div>
            <br>
            <div class="row">
                <label class="control-label col-md-3"><strong>@lang("core.date")</strong></label>
                <div class="col-md-9">
                    @if(!isset($leave_application->end_date))
                        {!! date('d-M-Y',strtotime($leave_application->start_date)) !!}
                    @else
                        {!! date('d-M-Y',strtotime($leave_application->start_date)) !!} - {!! date('d-M-Y',strtotime($leave_application->end_date)) !!}
                    @endif
                </div>
            </div>

            <br>
            <div class="row">
                <label class="control-label col-md-3"><strong>@lang("core.leaveDays")</strong></label>
                <div class="col-md-9">
                    {{$leave_application->days}}
                </div>
            </div>
            <div class="row">
                <label class="control-label col-md-3"><strong>@lang("core.reason")</strong></label>
                <div class="col-md-9">
                    {{$leave_application->reason}}
                </div>
            </div>
            <br>
            <div class="row">
                <label class="control-label col-md-3"><strong>@lang("core.appliedOn")</strong></label>
                <div class="col-md-9">
                    {!! date('d-M-Y',strtotime($leave_application->applied_on)) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <label class="control-label col-md-3"><strong>@lang("core.status")</strong></label>
                <div class="col-md-9 text-uppercase">
                    @if($leave_application->application_status=='rejected')
                        <span class="label label-danger">{{ trans("core.".$leave_application->application_status) }}</span>
                    @elseif($leave_application->application_status == 'approved')
                        <span class="label label-success">{{ trans("core.".$leave_application->application_status) }}</span>
                    @elseif($leave_application->application_status == 'pending')
                        <span class="label label-info">{{ trans("core.".$leave_application->application_status) }}</span>
                    @endif
                </div>
            </div>
            <br>


        </div>
    </div>
    <div class="modal-footer">
        @if($leave_application->application_status=='pending')
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="submit" name="application_status" data-loading-text="@lang("core.updating")..." class="btn green" value="{{ trans("core.btnApprove") }}" data-toggle="modal" href="#static_approve" onclick="show_approve({{ $leave_application->id }});return false;">
                        <input type="submit" name="application_status" data-loading-text="@lang("core.updating")..." class="btn red" value="{{ trans("core.btnReject") }}" data-toggle="modal" href="#static_reject" onclick="show_reject(' {{ $leave_application->id }} ');return false;">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">{{ trans("core.btnCancel") }}</button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

