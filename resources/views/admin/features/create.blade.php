{!! Form::open(array('url'=>"",'files' => true,'class'=>'form-horizontal add_form','id'=>'add_edit_form')) !!}
<div class="form-body">

    <div class="form-group">
        <label class="control-label col-md-3">{{trans('core.image')}}</label>
        <div class="col-md-8">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">

                    {!! HTML::image('http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image') !!}

                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"
                     style="max-width: 200px; max-height: 150px;">
                </div>
                <div>
                                                       <span class="btn default btn-file">
                                                       <span class="fileinput-new">
                                                       {{trans('core.changeImage')}} </span>
                                                       <span class="fileinput-exists">
                                                       {{trans('core.change')}} </span>
                                                       <input type="file" name="image">
                                                       </span>
                    <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                        {{trans('core.remove')}} </a>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('core.title')}}: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="title" name="title" placeholder="{{trans('core.title')}}"
            >
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label"> {{trans('core.description')}}: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <textarea class="form-control" id="description" style="height: 150px;"
                      name="description"></textarea>
        </div>
    </div>

</div>

<div class="modal-footer">
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbutton_add" onclick="addData();return false;"
                        class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>
                <button type="button" data-dismiss="modal"
                        class="btn dark btn-outline">{{trans('core.btnCancel')}}</button>
            </div>
        </div>
    </div>
</div>
{!!  Form::close()  !!}
