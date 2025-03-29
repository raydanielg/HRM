@extends('admin.adminlayouts.adminlayout')

@section('head')

<!-- BEGIN PAGE LEVEL STYLES -->
{!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
{!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
{!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css") !!}
{!! HTML::style("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css") !!}
{!!  HTML::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')!!}
{!! HTML::style("assets/global/plugins/icheck/skins/all.css") !!}
<!-- END PAGE LEVEL STYLES -->

@stop

@section('mainarea')
    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.referrals.editTitle")
            </h1></div>
    </div>
    <div class="page-bar">
    	<ul class="page-breadcrumb breadcrumb">
    		<li>
    			<a onclick="loadView('{{route('admin.dashboard.index')}}')">{{__('core.dashboard')}}</a>
    			<i class="fa fa-circle"></i>
    		</li>
    		<li>
    			<a onclick="loadView('{{ route('admin.referral_members.index') }}')">@lang("pages.referrals.indexTitle")</a>
    			<i class="fa fa-circle"></i>
    		</li>
    		<li>
    			<span class="active">@lang("pages.referrals.editTitle")</span>
    		</li>
    	</ul>

    </div>
    <!-- END PAGE HEADER-->			<!-- BEGIN PAGE CONTENT-->
    <div class="row">
    	<div class="col-md-12">
    		<!-- BEGIN EXAMPLE TABLE PORTLET-->

    		{{--INLCUDE ERROR MESSAGE BOX--}}

    		{{--END ERROR MESSAGE BOX--}}


    		<div class="portlet light bordred">
                <div class="portlet-title">
                    <div class="caption font-blue">
                        <i class="fa fa-edit font-blue"></i>@lang("core.editReferral")
                    </div>
                </div>
    			<div class="portlet-body form">

    				<!-- BEGIN FORM-->
    				{!! Form::open(['route'=>["admin.referral_members.update",$ref->id],'class'=>'form-horizontal ajax_form','method'=>'POST','files' => true]) !!}
                        <input name="_method" type="hidden" value="put">

    				<div class="form-body">
                        <div id="error"></div>

    					<div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.email')}}: <span class="required">
                                    * </span>
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="typeahead_example_1" name="email"
                                       placeholder="{{trans('core.email')}}" value="{{ $ref->email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.password')}}:
                            </label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" id="typeahead_example_1" name="password"
                                       placeholder="{{trans('core.password')}}" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.name')}}:<span class="required">
                            * </span>
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="typeahead_example_1" name="name"
                                       placeholder="{{trans('core.name')}}" value="{{ $ref->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.referralCode')}}: <span class="required">
                                    * </span>
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="typeahead_example_1" name="referral_code"
                                       placeholder="{{trans('core.referralCode')}}" value="{{ $ref->referral_code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.companyName')}}:
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="typeahead_example_1" name="company_name"
                                       placeholder="{{trans('core.companyName')}}" value="{{ $ref->company_name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.companyAddress')}}:
                            </label>

                            <div class="col-md-6">
                                <textarea class="form-control" id="company_address"
                                          name="company_address">{{ $ref->company_address }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.position')}}:
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="typeahead_example_1" name="position"
                                       placeholder="{{trans('core.position')}}" value="{{ $ref->position }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.phone')}}:
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="typeahead_example_1" name="phone"
                                       placeholder="{{trans('core.phone')}}" value="{{ $ref->phone }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.country')}}:
                            </label>
                            <div class="col-md-6">
                                <select class="select2me form-control" data-show-subtext="true" name="country">
                                   @foreach($countrieslist as $country)
                                       <option  value="{{$country->name}}" @if($ref->country==$country->name) selected @endif>{{$country->name}}</option>
                                   @endforeach
                               </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">{{trans("core.agreement")}}</label>

                            <div class="col-md-5">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="input-group input-large">
                                        <div class="form-control uneditable-input" data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp; <span
                                                    class="fileinput-filename">
                                            </span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                            <span class="fileinput-new">
                                                {{trans('core.selectFile')}} </span>
                                            <span class="fileinput-exists">
                                                {{trans('core.change')}} </span>
                                            <input type="file" name="agreement">
                                        </span>
                                        <a href="#" class="input-group-addon btn red fileinput-exists"
                                           data-dismiss="fileinput">
                                            {{trans('core.remove')}} </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                @if(isset($documents['IDProof']))
                                    <a href="{{route('admin.view_file',['IDProof',$documents['IDProof']])}}"
                                       target="_blank" class="btn purple">@lang("core.viewIDProof")</a>
                                @endif
                            </div>
                        </div>




    					<div class="form-group">
    						<label class="col-md-2 control-label">{{trans('core.dateOfAgreement')}}
    						</label>

    						<div class="col-md-6">
    							<div class="input-group input-medium date date-picker" data-date-viewmode="years">
    								<input type="text" class="form-control" name="date_of_agreement" id="agreementDate"
    									   data-date-format="dd-mm-yyyy" data-date-viewmode="years"
    									   value="{{ $date }}" readonly>
    								<span class="input-group-btn">
    									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
    								</span>
    							</div>
                            </div>
    					</div>

    					<div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.status')}}:<span class="required">
                                    * </span></label>

                            <div class="col-md-6">
                                <div class="radio-list">
                                    <label class="radio-inline"><input type="radio" name="status"
                                                                       @if($ref->status=='active') checked
                                                                       @endif class="icheck"
                                                                       value="active"> {{trans('core.active')}} </label>
                                    <label class="radio-inline"><input type="radio" name="status"
                                                                       @if($ref->status=='inactive') checked
                                                                       @endif class="icheck"
                                                                       value="inactive"> {{trans('core.inactive')}} </label>
                                </div>
                            </div>
                        </div>
    					<!-- END FORM-->

    				</div>
    				<div class="form-actions">
    					<div class="row">
    						<div class="col-md-offset-3 col-md-9">

    							<button type="button" id="editReferrals"
    									class="btn green" onclick="ajaxUpdateReferral()">
    								<i class="fa fa-edit"></i> {{trans('core.btnSubmit')}} </button>

    						</div>
    					</div>
    				</div>
    				{!!  Form::close()  !!}
    			</div>
    			<!-- END EXAMPLE TABLE PORTLET-->

    		</div>
    	</div>
    	<!-- END PAGE CONTENT-->
    </div>
@stop

@section('footerjs')
<!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') !!}
    {!! HTML::script('assets/global/plugins/select2/js/select2.min.js') !!}
    {!! HTML::script('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') !!}
    {!! HTML::script('assets/admin/pages/scripts/components-dropdowns.js') !!}
    {!! HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") !!}
    {!! HTML::script('assets/js/ajaxform/jquery.form.min.js')!!}
    {!! HTML::script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')!!}
    {!! HTML::script("assets/admin/pages/scripts/components-pickers.js") !!}
    {!! HTML::script('assets/global/plugins/icheck/icheck.min.js') !!}
    <script>
        $('#agreementDate').datepicker();
        $(document).ready(function() {
            ComponentsDropdowns.init();
            ComponentsPickers.init();
            $.fn.select2.defaults.set("theme", "bootstrap");
            $('.select2me').select2({
                placeholder: "Select",
                width: '100%',
                allowClear: false
            });
        });

        function ajaxUpdateReferral() {
            var that = $(".ajax_form");
                var posturl = that.attr('action');
                hideErrors();
                    that.ajaxSubmit({
                        url: posturl,
                        dataType: 'json',
                        method:'POST',
                    beforeSend: function () {
                           $('#editReferrals').attr("disabled", true);
                    },
                    success: function (response) {
                        $('#editReferrals').attr("disabled", false);
                        if(response.status == 'error'){
                        $('#error').addClass("alert alert-danger");
                        $("html, body").stop().animate({scrollTop:0}, '1000');
                            for(var key in response.message) {
                            if (response.message.hasOwnProperty(key)) {
                            var obj = response.message[key];
                        $('#error').append('<span class="fa fa-remove"></span> '+obj[0]+'</br>');
                                }
                            }
                        }else{
                        showResponseMessage(response, "error");
                        }
                    },
                    error: function (xhr, textStatus, thrownError) {
                        resposeArray = {
                        "status" : "fail",
                        "errorCode": "unkonwn",
                        "message": "Problem logging in, please try again!"
                        };
                        showResponseMessage(resposeArray, "error");

                    }
                });
            return false;
            }
    </script>
@stop
