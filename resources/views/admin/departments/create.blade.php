<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><strong><i
                        class="fa fa-plus"></i> {{trans('core.newDepartment')}}
            </strong></h4>
    </div>
    {!! Form::open(array('class'=>'horizontal-form ajax_form','method'=>'POST','id'=>'add_form'))!!}
    <div class="modal-body">

        <div class="form-body">
            <div class="form-group">
                <div>
                    <label class="control-label">{{trans('core.department')}}</label>
                    <input class="form-control" name="name" type="text" value=""
                           placeholder=""/>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <label class="control-label">{{trans('core.designations')}}</label>
                    <input class="form-control input-medium designation"
                           name="designation[0]" type="text" value=""
                           placeholder="{{trans('core.designation')}} #1"/>
                </div>
            </div>
            <div id="insertBefore"></div>
            <div class="form-group">
                <button type="button" id="plusButton" onclick="addMore();return false;" class="btn btn-sm green form-control-inline">
                    {{trans('core.addMoreDesignation')}} <i class="fa fa-plus"></i>
                </button>
            </div>

        </div>

        <!-- END FORM-->
    </div>
    <div class="modal-footer">
        <div class="form-actions">
            <button type="button" class="btn dark btn-outline"
                    data-dismiss="modal">{{ trans("core.btnCancel") }}</button>
            <button type="button" id="submitbutton_add"
                    class="btn green" onclick="addSubmit();return false;"><i
                        class="fa fa-check"></i> {{trans('core.btnSubmit')}}</button>
        </div>
    </div>
{!! Form::close() !!}

<!-- END EXAMPLE TABLE PORTLET-->
</div>

