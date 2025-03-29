<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><strong><i class="fa fa-edit"></i> {{trans('core.editAdmin')}}</strong></h4>
    </div>
    {!! Form::open(['url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'edit_form']) !!}
    <div class="modal-body" id="edit-modal-body">
        <div class="portlet-body form">

            <div id="error_edit"></div>
            <div class="form-body">

                <div class="form-group" id="name_edit">
                    <label class="col-md-4 control-label">{{trans('core.name')}}: <span class="required">
							* </span>
                    </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" id="name"
                               placeholder="{{trans('core.name')}}"
                               value="{{$admin->name}}">
                        <span class="help-block" id="name_edit_message"></span>
                    </div>
                </div>
                <div class="form-group" id="email_edit">
                    <label class="col-md-4 control-label">{{trans('core.email')}}: <span class="required">
							* </span>
                    </label>

                    <div class="col-md-8">
                        <input type="text" class="form-control" name="email" id="email"
                               placeholder="{{trans('core.email')}}"
                               value="{{$admin->email}}">
                        <span class="help-block" id="email_edit_message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.password')}}:
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="{{trans('core.password')}}">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">{{trans('core.confirmPassword')}}:
                    </label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password_confirmation"
                               id="password_confirmation"
                               placeholder="{{trans('core.confirmPassword')}}">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group" id="dept_edit">
                    <label class="col-md-4 control-label">{{trans('core.departments')}}: <span
                                class="required">
                                    * </span>
                    </label>

                    <div class="col-md-8">
                        <div class="checkbox-list">
                            @foreach($department as $dept)
                                <label>
                                    <input name="departments[]" type="checkbox"
                                           @if($dept->checkDepartment($admin->id)) checked
                                           @endif value="{{$dept->id}}"> {{$dept->name}} </label>
                            @endforeach
                            <span class="help-block" id="dept_edit_message"></span>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
    <div class="modal-footer">
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" id="submitbutton_edit" onclick="updateData({{$admin->id}});return false;"
                            class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>

                </div>
            </div>
        </div>
    </div>
{!!  Form::close()  !!}            <!-- END EXAMPLE TABLE PORTLET-->
</div>
<script type="text/javascript">
    $("input[type='checkbox']").uniform();
</script>
