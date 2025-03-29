<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

        <h4 class="modal-title"><strong>
                <i class="la la-edit"></i>  Edit leaves type</strong></h4>
    </div>
    <div class="modal-body">
        <div class="panel-body form">

            <!-- BEGIN FORM-->

            {!!  Form::open(['method' => 'PUT', 'id' => 'leave_type_update_form', 'class'=>'form-horizontal'])  !!}

            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.typeOfLeave')}}<span
                                class="required">
                                        * </span>
                    </label>

                    <div class="col-md-6">
                        <input type="text" class="form-control input-medium date-picker" id="leaveType"
                               name="leaveType"
                               value="{{ $leavetype->leaveType }}"
                               placeholder="{{trans('core.typeOfLeave')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.noOfDays')}}
                        <span
                                class="required">
                                        * </span>
                        </span>
                    </label>

                    <div class="col-md-6">
                        <input type="text" class="form-control only-num input-medium date-picker"
                               name="num_of_leave" id="num_of_leave"
                               value="{{ $leavetype->num_of_leave}}"
                               placeholder="{{trans('core.noOfDays')}}"
                        >
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>


            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="button" onclick="addUpdateLeaveType({{$leavetype->id}})"
                                class="btn btn-primary"> @if(isset($leavetype))<i class="la la-edit"></i>  Update @else
                                <i class="la la-plus"></i>   Add @endif</button>

                    </div>
                </div>
            </div>
        {!!  Form::close()  !!}
        <!-- END FORM-->
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>


