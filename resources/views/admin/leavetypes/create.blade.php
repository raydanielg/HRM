<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

        <h4 class="modal-title"><strong>
                @if(isset($leavetype))<i class="la la-edit"></i>  Edit @else <i
                        class="la la-plus"></i>   Add @endif leaves type</strong></h4>
    </div>
    <div class="modal-body">
        <div class="panel-body form">
            {!! Form::open(array('class'=>'form-horizontal ','method'=>'POST','id'=>'leave_type_update_form')) !!}
            <div class="modal-body">
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('core.typeOfLeave')}}<span
                                        class="required">
                                        * </span>
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control input-medium date-picker" id="leaveType"
                                       name="leaveType"
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
                                       placeholder="{{trans('core.noOfDays')}}"
                                >
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <!-- END FORM-->
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="button" onclick="addUpdateLeaveType();return false;" class="btn green">
                            <i class="fa fa-check"></i> @lang('core.btnSubmit')</button>

                    </div>
                </div>
            </div>
            {!!  Form::close()  !!}

        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>


