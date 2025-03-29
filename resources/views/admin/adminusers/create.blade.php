<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">{{trans('core.addNewAdmin')}}</h4>
    </div>
    <div class="modal-body">
        <div class="form">

            <!-- BEGIN FORM-->
            {!! Form::open(array('class'=>'form-horizontal ajax_form','id'=>'add_form')) !!}

            <div id="error"></div>
            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.name')}}: <span class="required">
                                    * </span>
                    </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" id="name"
                               placeholder="{{trans('core.name')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.email')}}: <span class="required">
                                    * </span>
                    </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="email" id="email"
                               placeholder="{{trans('core.email')}}">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.password')}}: <span
                                class="required">
                                    * </span>
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="{{trans('core.password')}}">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.confirmPassword')}}: <span
                                class="required">
                                    * </span>
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password_confirmation"
                               id="password_confirmation"
                               placeholder="{{trans('core.confirmPassword')}}">
                        <span class="help-block"></span>
                    </div>
                </div>


            </div>


            <!-- END FORM-->
        </div>
    </div>

    <div class="modal-footer">
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" id="submitbutton_add" onclick="addAdminSubmit();return false;"
                            class=" btn green">{{trans('core.btnSubmit')}}
                    </button>

                </div>
            </div>
        </div>
        {!!  Form::close()  !!}
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
