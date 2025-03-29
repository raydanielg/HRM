{!! Form::open(array('url'=>"",'class'=>'form-horizontal add_form','id'=>'add_form_plan')) !!}
<div class="form-body">

    <div class="form-group">
        <label class="col-md-3 control-label">{{trans('core.name')}}: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="plan_name" name="plan_name" placeholder="{{trans('core.name')}}"
                   value="{{$plan->plan_name}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Stripe Id: <span class="required">
                        * </span>
        </label>
        <div class="col-md-4">
            <input type="text" class="form-control" id="stripe_monthly_plan_id" name="stripe_monthly_plan_id" placeholder="Monthly id"
                   value="{{$plan->stripe_monthly_plan_id}}">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="stripe_annual_plan_id" name="stripe_annual_plan_id" placeholder="Annual id"
                   value="{{$plan->stripe_annual_plan_id}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Price: <span class="required">
                    * </span>
        </label>
        <div class="col-md-4">
            <input type="text" class="form-control" id="monthly_price" name="monthly_price" placeholder="Monthly Price"
                   value="{{$plan->monthly_price}}">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="annual_price" name="annual_price" placeholder="Annual Price"
                   value="{{$plan->annual_price}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Start User: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="start_user_count" name="start_user_count"
                   placeholder="Start User:"
                   value="{{$plan->start_user_count}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">End User: <span class="required">
                        * </span>
        </label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="end_user_count" name="end_user_count"
                   placeholder="End User:"
                   value="{{$plan->end_user_count}}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label">Status: <span class="required">
                    * </span>
        </label>
        <div class="col-md-8">
            {!!  Form::radio('status',1,($plan->status=='1'))  !!} Enabled<br>
            {!!  Form::radio('status', 0,($plan->status=='0'))  !!} Disabled
        </div>
    </div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" id="submitbutton_add" onclick="addData();return false;"
                    class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>

        </div>
    </div>
</div>
{!!  Form::close()  !!}