{!! Form::open(array('url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'edit_form')) !!}
<div id="error_edit"></div>
<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label">License No: <span class="required">
                    * </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="license_number" name="license_number" placeholder="license number" value="{{$license->license_number}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('core.name')}}: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="name" name="name" placeholder="{{trans('core.name')}}" value="{{$license->name}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('core.email')}}: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="email" class="form-control" id="email" name="email" placeholder="{{trans('core.name')}}" value="{{$license->email}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Company: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="email" class="form-control" id="company" name="company" placeholder="Company" value="{{$license->company}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Subdomain: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="email" class="form-control" id="subdomain" name="subdomain" placeholder="Subdomain" value="{{$license->subdomain}}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">License Type: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            {!!  Form::select('license_type_id', $types, $license->license_type_id,['class'=>'form-control'])  !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Expires On:
        </label>
        <div class="col-md-8">
            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                <input type="text" class="form-control" name="expires_on" readonly value="{!! date('d-m-Y',strtotime($license->expires_on)) !!}">
                   <span class="input-group-btn">
                   <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                   </span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Status: <span class="required">
                    * </span>
        </label>
        <div class="col-md-8">
            {!!  Form::radio('status','Valid',($license->status=='Valid'))  !!} Valid<br>
            {!!  Form::radio('status','Disabled',($license->status=='Disabled'))  !!} Disabled<br>
            {!!  Form::radio('status', 'Expired',($license->status=='Expired'))  !!} Expired
        </div>
    </div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" id="submitbutton_edit" onclick="updateData('{{$license->license_number}}');return false;"  class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>

        </div>
    </div>
</div>
{!!  Form::close()  !!}