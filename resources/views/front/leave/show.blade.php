<div class="modal-header">
    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
    <h4 id="myLargeModalLabel" class="modal-title">
        Leave Application
    </h4>
</div>
<div class="modal-body" >
    <div class="portlet-body form">

        <div class="row">
            <label class="control-label col-md-3"><strong>Leave Type</strong></label>

            <div class="col-md-9">

                @if($leave_application->halfDayType == 'yes')
                    Half Day -  {{$leave_application->leaveType}}
                @else
                    {{ucfirst($leave_application->leaveType)}}
                @endif
            </div>
        </div>
        <br>

        <div class="row">
            <label class="control-label col-md-3"><strong>Date</strong></label>

            <div class="col-md-9">
                @if(!isset($leave_application->end_date))
                    {{date('d-M-Y',strtotime($leave_application->start_date))}}
                @else
                    {{date('d-M-Y',strtotime($leave_application->start_date))}}
                    to  {{date('d-M-Y',strtotime($leave_application->end_date))}}
                @endif
            </div>
        </div>
        <br>

        <div class="row">
            <label class="control-label col-md-3"><strong>Reason</strong></label>

            <div class="col-md-9">
                {{$leave_application->reason}}
            </div>
        </div>
        <br>

        <div class="row">
            <label class="control-label col-md-3"><strong>Applied on</strong></label>

            <div class="col-md-9">
                {{date('d-M-Y',strtotime($leave_application->applied_on))}}
            </div>
        </div>
        <br>


    </div>
</div>

