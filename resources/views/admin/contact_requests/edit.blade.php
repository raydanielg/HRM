{!! Form::open(array('url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'edit_form')) !!}

<div id="error_edit"></div>
<div class="form-body">

    <div class="form-group">
        <label class="col-md-2 control-label">{{trans('core.id')}}: <span class="required">
					* </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="email_id" name="email_id" placeholder="{{trans('core.name')}}" value="{{$email_template->email_id}}" readonly >
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Subject: <span class="required">
					* </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="subject" name="subject" placeholder="{{trans('core.email')}}" value="{{$email_template->subject}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Body: <span class="required">
					* </span>
        </label>
        <div class="col-md-8">
            <textarea id="body" class="form-control" name="body">{{$email_template->body}}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">VARIABLES USED:
        </label>
        <div class="col-md-10">
                {{$email[$email_template->email_id]}}
            </div>
    </div>

</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" id="submitbutton_edit" onclick="updateData({{$email_template->id}});return false;"  class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>

        </div>
    </div>
</div>
{!!  Form::close()  !!}