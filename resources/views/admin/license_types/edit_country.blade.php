{!! Form::open(array('url'=>"",'class'=>'form-horizontal ','method'=>'POST','id'=>'edit_form')) !!}
    <div id="error_edit"></div>
    <div class="form-body">

        <div class="form-group">
            <label class="col-md-3 control-label">License Type: <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <span  class='label label-warning'>{{ $license->name }}</span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Country: <span class="required">
                        * </span>
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="{{$license->country}}">
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 control-label">Currency Code: <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="currency_code" value="{{$license->currency_code}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Currency Symbol: <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" placeholder="currency_symbol" value="{{$license->currency_symbol}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Price: <span class="required">
                    * </span>
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="{{$license->price}}">
            </div>
        </div>

    </div>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" id="submitbutton_edit" onclick="updateData({{$license->id}},'country');return false;"  class=" btn green"><i class="fa fa-edit"></i> {{trans('core.btnSubmit')}}</button>

            </div>
        </div>
    </div>
{!!  Form::close()  !!}