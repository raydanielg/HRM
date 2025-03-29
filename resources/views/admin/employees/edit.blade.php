@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!!  HTML::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')!!}
    {!!  HTML::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css')!!}
    {!!  HTML::style("assets/global/plugins/cropper/cropper.min.css")!!}
    <!-- END PAGE LEVEL STYLES -->
@stop


@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{ trans("pages.employees.editTitle") }}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{route('admin.employees.index')}}')">{{ trans("pages.employees.indexTitle") }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">{{ trans("pages.employees.editTitle") }}</span>
            </li>
        </ul>
    </div>            <!-- END PAGE HEADER-->
    <div class="row ">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-purple-wisteria">
                        <i class="fa fa-user font-purple-wisteria"></i>{{trans('core.personalDetails')}}
                    </div>
                    <div class="actions">

                        <a href="javascript:;" onclick="UpdateDetails('{!! $employee->id !!}','personal')"

                           class="btn btn-sm btn-success ">
                            <i class="fa fa-save"></i> {{trans('core.btnPersonalInfo')}} </a>
                    </div>
                </div>


                <div class="portlet-body">


                    {{--------------------Personal Info Form--------------------------------------------}}

                    {!!  Form::open(['method' => 'PUT','class'   =>  'form-horizontal','id'  =>  'personal_details_form','files'=>true])!!}

                    <input type="hidden" name="updateType" class="form-control" value="personalInfo">


                    @if (Session::get('errorPersonal'))

                        <div class="alert alert-danger alert-dismissable ">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            @foreach (Session::get('errorPersonal') as $error)
                                <p><strong><i class="fa fa-warning"></i></strong> {!!  $error !!}</p>
                            @endforeach
                        </div>
                    @endif


                    <div class="form-body">
                        <div class="form-group ">
                            <label class="control-label col-md-3">{{trans('core.image')}}
                                {!! help_text("employeeImageSize") !!}
                            </label>

                            <div class="col-md-9">

                                <!-- Modal -->
                                <div class="modal fade" id="cropModal" aria-labelledby="modalLabel" role="dialog"
                                     tabindex="-1" data-backdrop="static">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modalLabel">Crop Image</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div>
                                                            <img id="cropImage" src="" alt="" style="max-height: 500px">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="cropButton" class="btn btn-primary"
                                                        data-dismiss="modal">Crop Selected
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                        {!! HTML::image($employee->profile_image_url,'ProfileImage',['height'=>'80px', "id" => "imagePath"])!!}
                                        <input type="hidden" name="hiddenImage" value="{{$employee->profile_image}}">
                                    </div>

                                    <input type="hidden" value="" name="cropData" id="cropData"/>

                                    <div class="fileinput-preview fileinput-exists thumbnail" id="result"
                                         style="max-width: 200px; max-height: 200px;"></div>
                                    <div>
									<span class="btn default btn-file">
										<span class="fileinput-new">
											{{ trans('core.selectImage')}} </span>
										<span class="fileinput-exists">
											{{ trans('core.change')}} </span>
										<input type="file" id="picImage" name="profile_image">
									</span>
                                        <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                                            {{ trans('core.remove')}} </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    {{--                                    {!! trans('messages.imageSizeLimit', ["size" => '872x724 pixels']) !!}--}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.name')}} <span
                                        class="required">* </span></label>

                            <div class="col-md-9">
                                <input type="text" name="full_name" class="form-control" value="{{$employee->full_name}}">
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label class="col-md-3 control-label">{{trans('core.father_name')}}</label>--}}

                            {{--<div class="col-md-9">--}}
                                {{--<input type="text" name="father_name" class="form-control"--}}
                                       {{--value="{{$employee->father_name}}">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label class="control-label col-md-3">{{trans('core.dob')}}</label>

                            <div class="col-md-3">
                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy"
                                     data-date-viewmode="years">
                                    <input type="text" class="form-control" name="date_of_birth" readonly
                                           value="@if(empty($employee->date_of_birth))@else{{date('d-m-Y',strtotime($employee->date_of_birth))}}@endif">
                                    <span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.gender')}}</label>

                            <div class="col-md-9">
                                <select class="form-control" name="gender">

                                    <option value="male" @if($employee->gender=='male') selected @endif>{{ __('core.male') }}</option>
                                    <option value="female" @if($employee->gender=='female') selected @endif>{{ __('core.female') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.phone')}}</label>

                            <div class="col-md-9">
                                <input type="text" name="mobile_number" class="form-control"
                                       value="{{$employee->mobile_number}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.local_address')}}</label>

                            <div class="col-md-9">
							<textarea name="local_address" class="form-control"
                                      rows="3">{{$employee->local_address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.permanent_address')}}</label>

                            <div class="col-md-9">
							<textarea name="permanent_address" class="form-control"
                                      rows="3">{{$employee->permanent_address}}</textarea>
                            </div>
                        </div>
                        <h4 class="block">{{trans('core.accountLogin')}}</h4>

                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.email')}}<span
                                        class="required">* </span></label>

                            <div class="col-md-9">
                                <input type="text" name="email" class="form-control" value="{{$employee->email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.password')}}</label>

                            <div class="col-md-9">
                                <input type="hidden" name="oldpassword" value="{{$employee->password}}">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="fa fa-industry font-red-sunglo"></i>{{trans('core.companyDetails')}}
                    </div>
                    <div class="actions">
                        <a href="javascript:;"
                           onclick="UpdateDetails('{{$employee->id}}','company');return false"
                           class="btn btn-sm btn-success ">
                            <i class="fa fa-save"></i> {{trans('core.btnCompany')}} </a>
                    </div>
                </div>
                <div class="portlet-body">

                    {{--------------------Company Form--------------------------------------------}}
                    {!! Form::open(['method' => 'PUT','class'   =>  'form-horizontal','id'  =>  'company_details_form']) !!}

                    <input type="hidden" name="updateType" class="form-control" value="company">

                    <div id="alert_company">
                        {{--INLCUDE ERROR MESSAGE BOX--}}

                        {{--END ERROR MESSAGE BOX--}}
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.employeeID')}}<span
                                        class="required">* </span></label>

                            <div class="col-md-9">
                                <input type="text" name="employeeID" class="form-control"
                                       value="{{ $employee->employeeID }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.department')}}<span
                                        class="required">* </span></label>

                            <div class="col-md-9">
                                {!!  Form::select('department', $department,$designation->department_id,['class' => 'form-control select2me','id'=>'department','onchange'=>'dept();return false;'])  !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.designation')}}<span
                                        class="required">* </span></label>

                            <div class="col-md-9">

                                <select class="select2me form-control" name="designation" id="designation">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.annualOrCredit')}} {!! help_text("creditLeaves") !!}</label>

                            <div class="col-md-9">
                                <input type="text" name="annual_leave" class="form-control"
                                       value="{{$employee->annual_leave}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">{{trans('core.dateOfJoining')}}</label>

                            <div class="col-md-3">
                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy"
                                     data-date-viewmode="years">
                                    <input type="text" class="form-control" name="joining_date" readonly
                                           value="@if(empty($employee->joining_date))00-00-0000 @else {{date('d-m-Y',strtotime($employee->joining_date))}} @endif">
                                    <span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{trans('core.exitDate')}} {!! help_text("exitDate") !!}</label>

                            <div class="col-md-3">
                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy"
                                     data-date-viewmode="years">
                                    <input type="text" class="form-control" name="exit_date" readonly
                                           value="@if(empty($employee->exit_date)) @else {{date('d-m-Y',strtotime($employee->exit_date))}} @endif">
                                    <span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{trans('core.status')}}</label>

                            <div class="col-md-9">
                                <input type="checkbox" value="active" onchange="remove_exit();" class="make-switch"
                                       name="status" @if($employee->status=='active')checked
                                       @endif data-on-color="success"
                                       data-on-text="Active" data-off-text="Inactive" data-off-color="danger">
                                <span class="help-block">
								(@lang("messages.statusRemoveWarning"))
							</span>
                            </div>
                        </div>

                        <hr>
                        <h4><strong>{{ trans("core.salary") }} ({{$loggedAdmin->company->currency_symbol}})</strong></h4>
                        <div id="salaryData">
                            @foreach($employee->salaries as $salary)
                                <div id="salary{{$salary->id}}">
                                    <div class="form-group">
                                        <div class="col-md-5">
                                            @if(($salary->type=='basic' || $salary->type=='hourly_rate'))
                                                <input type="hidden" class="form-control" name="type[{{$salary->id}}]"
                                                       value="{{$salary->type}}">
                                                <label class="control-label">@lang('core.'.$salary->type)</label>
                                            @else
                                                <input type="text" class="form-control" name="type[{{$salary->id}}]"
                                                       value="{{$salary->type}}">
                                            @endif
                                        </div>

                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="salary[{{$salary->id}}]"
                                                   value="{{$salary->salary}}">
                                        </div>

                                        <div class="col-md-2">
                                            <a class="btn btn-sm red"
                                               onclick="del('{{$salary->id}}','{{$salary->type}}')"><i
                                                        class="fa fa-trash"></i> </a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="" href="javascript:;" onclick="showSalary({{$employee->id}})">
                            {{ trans("core.addSalary") }}
                            <i class="fa fa-plus"></i> </a>
                    </div>
                    {!! Form::close()!!}


                    {{----------------Company Form end -------------}}

                </div>
            </div>

            <div class="portlet light bordered ">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="fa fa-money font-red-sunglo"></i>{{trans('core.bankDetails')}}
                    </div>
                    <div class="actions">
                        <a href="javascript:;"
                           onclick="UpdateDetails('{{$employee->id}}','bank');return false"
                           class="btn btn-sm btn-success ">
                            <i class="fa fa-save"></i> {{trans('core.btnSave')}} </a>
                    </div>
                </div>
                <div class="portlet-body">

                    {{--------------------Bank Account Form--------------------------------------------}}
                    {!! Form::open(['method' => 'PUT','class'   =>  'form-horizontal','id'  =>  'bank_details_form']) !!}

                    <input type="hidden" name="updateType" class="form-control" value="bank">

                    <div id="alert_bank"></div>
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.accountHolder')}}</label>

                            <div class="col-md-9">

                                <input type="text" name="account_name" class="form-control"
                                       value="{{isset($employee->bank_details->account_name) ? $employee->bank_details->account_name : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.account_number')}}</label>

                            <div class="col-md-9">
                                <input type="text" name="account_number" class="form-control"
                                       value="{{isset($employee->bank_details->account_number) ? $employee->bank_details->account_number : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.bank')}}</label>

                            <div class="col-md-9">
                                <input type="text" name="bank" class="form-control"
                                       value="{{isset($employee->bank_details->bank) ? $employee->bank_details->bank : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.bin')}} {!! help_text("bankIdentificationCode") !!}</label>

                            <div class="col-md-9">
                                <input type="text" name="bin" class="form-control"
                                       value="{{isset($employee->bank_details->bin) ? $employee->bank_details->bin : ''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.branch')}}</label>

                            <div class="col-md-9">
                                <input type="text" name="branch" class="form-control"
                                       value="{{isset($employee->bank_details->branch) ? $employee->bank_details->branch : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('core.tax_payer_id')}} {!! help_text("taxPayerID") !!}</label>

                            <div class="col-md-9">
                                <input type="text" name="tax_payer_id" class="form-control"
                                       value="{{isset($employee->bank_details->tax_payer_id) ? $employee->bank_details->tax_payer_id : ''}}">
                            </div>
                        </div>

                    </div>
                    {!! Form::close()!!}
                    {{-------------------Bank Account Form end-----------------------------------------}}


                </div>
            </div>
        </div>
    </div>
    <div class="clearfix">
        <div class="row ">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-purple-wisteria">
                            <i class="fa fa-file font-purple-wisteria"></i>{{trans('core.documents')}}
                        </div>
                        <div class="actions">
                            <button onclick="UpdateDetails('{!! $employee->id !!}','documents')"

                                    class="btn btn-sm btn-success ">
                                <i class="fa fa-save"></i> {{trans('core.btnDocuments')}} </button>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="portlet-body">
                            {{--------------------Documents Info Form--------------------------------------------}}

                            {!! Form::open(['method' => 'PUT','route'=> ['admin.employees.update',$employee->employeeID ],'class'   =>  'form-horizontal','id'  =>  'documents_details_form','files'=>true])!!}

                            <input type="hidden" name="updateType" class="form-control" value="documents">


                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{trans('core.resume')}}</label>

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
												<input type="file" name="resume">
											</span>
                                                <a href="#" class="input-group-addon btn red fileinput-exists"
                                                   data-dismiss="fileinput">
                                                    {{trans('core.remove')}} </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        @if(isset($documents['resume']))
                                            <a href="https://docs.google.com/viewer?url={{$documents['resume']}}"
                                               target="_blank" class="btn btn-sm purple">@lang("core.viewResume")</a>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">@lang("core.offerLetter")</label>

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
												<input type="file" name="offerLetter">
											</span>
                                                <a href="#" class="input-group-addon btn red fileinput-exists"
                                                   data-dismiss="fileinput">
                                                    {{trans('core.remove')}} </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        @if(isset($documents['offerLetter']))
                                            <a  href="https://docs.google.com/viewer?url={{$documents['offerLetter']}} "
                                               target="_blank" class="btn btn-sm purple">@lang("core.viewOfferLetter")</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">@lang("core.joiningLetter")</label>

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
												<input type="file" name="joiningLetter">
											</span>
                                                <a href="#" class="input-group-addon btn red fileinput-exists"
                                                   data-dismiss="fileinput">
                                                    {{trans('core.remove')}} </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        @if(isset($documents['joiningLetter']))
                                            <a  href="https://docs.google.com/viewer?url={{$documents['joiningLetter']}}"
                                               target="_blank" class="btn btn-sm purple">@lang("core.viewJoiningLetter")</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">@lang("core.contractOrAgreement")</label>

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
												<input type="file" name="contract">
											</span>
                                                <a href="#" class="input-group-addon btn red fileinput-exists"
                                                   data-dismiss="fileinput">
                                                    {{trans('core.remove')}} </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        @if(isset($documents['contract']))
                                            <a  href="https://docs.google.com/viewer?url={{$documents['contract']}}"
                                               target="_blank"
                                               class="btn btn-sm purple">@lang("core.viewContractOrAgreement")</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">@lang("core.idProof")</label>

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
												<input type="file" name="IDProof">
											</span>
                                                <a href="#" class="input-group-addon btn red fileinput-exists"
                                                   data-dismiss="fileinput">
                                                    {{trans('core.remove')}} </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        @if(isset($documents['IDProof']))
                                            <a  href="https://docs.google.com/viewer?url={{$documents['IDProof']}}"
                                               target="_blank" class="btn btn-sm purple">@lang("core.viewIDProof")</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        {{-------------DELETE MODAL CALLING------------}}
        @include('admin.common.delete')
        @include('admin.common.show-modal')
        {{---------------DELETE MODAL CALLING END--------}}


    </div>

    {{------------------------------------END NEW SALARY ADD MODALS--------------------------------------}}

@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')!!}
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')!!}
    {!! HTML::script('assets/admin/pages/scripts/components-pickers.js')!!}
    {!! HTML::script("assets/global/plugins/cropper/cropper.min.js")!!}

    <!-- END PAGE LEVEL PLUGINS -->




    <script>
        jQuery(document).ready(function () {
            ComponentsPickers.init();
            dept();
        });


        function dept() {

            $.getJSON("{{ route('admin.departments.ajax_designation')}}",
                {department_id: $('#department').val()},
                function (data) {
                    var model = $('#designation');
                    model.empty();
                    var selected = '';
                    var match = '{{ $employee->designation}}';
                    $.each(data, function (index, element) {
                        if (element.id == match) selected = 'selected';
                        else selected = '';
                        model.append("<option value='" + element.id + "' " + selected + ">" + element.designation + "</option>");
                    });

                });


        }


        // Add New Salary
        function saveSalary(id) {
            var url = "{{ route('admin.salary.store') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '#save_salary',
                data: $('#save_salary').serialize(),
                success: function (response) {
                    if (response.status == "success") {
                        $('#showModal').modal('hide');
                        $('#salaryData').append(response.viewData);
                    }
                }
            });
        }

        // Show Salary Modal
        function showSalary(id) {
            $('#showModal .modal-dialog').removeClass("modal-md").addClass("modal-lg");
            var url = "{{ route('admin.add-salary-modal',[':id']) }}";
            url = url.replace(':id', id);
            $.ajaxModal('#showModal', url);
            $('#showModal_div').removeClass("modal-dialog modal-lg").addClass("modal-dialog modal-md");
        }

        // Show Delete Modal and delete salary
        function del(id, type) {

            $('#deleteModal').modal('show');

            $("#deleteModal").find('#info').html('Are you sure ! You want to delete <strong>' + type + '</strong> Salary?.');

            $('#deleteModal').find("#delete").off().click(function () {

                var url = "{{ route('admin.salary.destroy',':id') }}";
                url = url.replace(':id', id);

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'DELETE',
                    url: url,
                    data: {'_token': token},
                    container: "#deleteModal",
                    success: function (response) {
                        if (response.status == "success") {
                            $('#deleteModal').modal('hide');
                            $('#salary' + id).remove();
                        }
                    }
                });

            });
        }


        function remove_exit() {
            if ($("input[name=status]:checked").val() == "active") {
                $("input[name=exit_date]").val("");
            }
        }


        $("input[name=exit_date]").change(function () {
            $("input[name=status]").bootstrapSwitch('state', false);

        });
    </script>

    <script>
        $(function () {

            var $previews = $('.preview');

            $('#cropModal').on('shown.bs.modal', function () {
                var $image = $('#cropImage');
                var $button = $('#cropButton');
                var $result = $('#result');
                var croppable = false;

                $image.cropper({
                    aspectRatio: 1,
                    viewMode: 2,
                    guides: false,
                    zoomable: false,
                    zoomOnTouch: false,
                    zoomOnWheel: false,
                    build: function () {
                        croppable = true;
                    }
                });

                $button.on('click', function () {
                    var croppedCanvas;
                    var roundedCanvas;

                    if (!croppable) {
                        return;
                    }

                    // Crop
                    croppedCanvas = $image.cropper('getCroppedCanvas');

                    // Show
                    $result.html('<img src="' + croppedCanvas.toDataURL() + '">');
                });

            }).on('hidden.bs.modal', function () {
                var $image = $('#cropImage');
                cropBoxData = $image.cropper('getData');
                canvasData = $image.cropper('getCanvasData');
                $image.cropper('destroy');
                $("#cropData").val(JSON.stringify(cropBoxData));
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#cropModal').modal('show');
                    $('#cropImage').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#picImage").change(function () {
            readURL(this);
        });

        // Javascript function to update the company info and Bank Info
        function UpdateDetails(id, type) {

            var form_id = '#' + type + '_details_form';
            var alert_div = '#' + type + '_alert';

            var url = "{{ route('admin.employees.update',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                type: 'POST',
                url: url,
                container: form_id,
                file: true,
                alertDiv: alert_div
            });
        }

    </script>


@stop
