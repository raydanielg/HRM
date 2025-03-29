{!! Form::open(array('url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'edit_form')) !!}
    <div id="error_edit"></div>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label">TYPE: <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <span  class='label label-warning'>{{ $license->type }}</span>
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
    @if($license->type=='Cloud')
        <div class="form-group">
            <label class="col-md-3 control-label">Free Users: <span class="required">
                        * </span>
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="free_users" name="free_users" placeholder="Free Users" value="{{$license->free_users}}">
            </div>
        </div>
 @endif

        <div class="form-group">
            <label class="col-md-3 control-label">Price: <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="price" name="price" placeholder="One Time Fees" value="{{$license->price}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Status: <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                {!!  Form::radio('status','Enabled',($license->status=='Enabled'))  !!} Enabled<br>
                {!!  Form::radio('status', 'Disabled',($license->status=='Disabled'))  !!} Disabled
            </div>
        </div>
    </div>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbutton_edit" onclick="updateData({{$license->id}},'license');return false;"  class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>

            </div>
        </div>
    </div>
{!!  Form::close()  !!}