<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><strong><i class="fa fa-edit"></i> {{trans('core.editAdmin')}}</strong></h4>
    </div>
    {!! Form::open(['class'=>'form-horizontal ajax_form','method'=>'POST','id'=>'edit_form']) !!}
    <div class="modal-body" id="edit-modal-body">
        <div class="portlet-body form">

            <div id="error_edit"></div>
            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.name')}}: <span class="required">
							* </span>
                    </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" placeholder="{{trans('core.name')}}"
                               value="{{$admin->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.email')}}: <span class="required">
							* </span>
                    </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="email" placeholder="{{trans('core.email')}}"
                               value="{{$admin->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.password')}}:
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password"
                               placeholder="{{trans('core.password')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.confirmPassword')}}:
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password_confirmation"
                               placeholder="{{trans('core.confirmPassword')}}">
                    </div>
                </div>


            </div>


        </div>
    </div>
    <div class="modal-footer">
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="button" id="submitbutton_edit" onclick="updateAdminSubmit({{$admin->id}});return false;"
                            class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>

                </div>
            </div>
        </div>
    </div>
{!!  Form::close()  !!}            <!-- END EXAMPLE TABLE PORTLET-->
</div>

