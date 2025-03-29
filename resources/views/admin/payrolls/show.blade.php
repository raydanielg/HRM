@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")!!}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


			<!-- BEGIN PAGE HEADER-->
			<div class="page-head"><div class="page-title"><h1>
			{{$pageTitle}}
			</h1></div></div>
			<div class="page-bar">
				<ul class="page-breadcrumb breadcrumb">
					<li>
						<a onclick="loadView('{{route('admin.dashboard.index')}}')">Home</a>
						<i class="fa fa-circle"></i>
					</li>
					<li>
						<a href="{{ route('admin.payrolls.index') }}">Payroll</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="">Salary Slip</a>
					</li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			{!! Form::open(array('class'=>'form-horizontal','method'=>'POST','id'=>'salary-form')) !!}
			<div class="row">
			{{--Employee info--}}
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->

                {{--INLCUDE ERROR MESSAGE BOX--}}
                      <div id="error"></div>
                {{--END ERROR MESSAGE BOX--}}

							<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="caption font-dark">
							Employee Info
						</div>
					</div>
					<div class="portlet-body">
							<div class="row">

										<div class="col-md-3">
											<div class="form-group">
												<div class="col-md-9">

												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<div class="col-md-9">
												 {!! HTML::image($payroll->employee->profile_image_url,'ProfileImage',['height'=>'100px']) !!}

												</div>
											</div>
										</div>
									<!--/span-->
									<div class="col-md-4">
										<div class="form-group">
											<div class="col-md-9">
												<ul>
													<li><h4>EmployeeID: {{$payroll->employee->employeeID}}</h4></li>
													<li><h4>Name:  {{$payroll->employee->full_name}}</h4></li>
													<li><h4>Month: {{date('F', strtotime($payroll->month . '01'));}}</h4></li>
													<li><h4>Year:  {{$payroll->year}}</h4></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<div class="col-md-9">

											</div>

										</div>
									</div>

										<!--/span-->
								</div>
					</div>
				</div>
				</div>

							<div class="col-md-12">
                        					<!-- BEGIN EXAMPLE TABLE PORTLET-->

                                        {{--INLCUDE ERROR MESSAGE BOX--}}
                                              <div id="error"></div>
                                        {{--END ERROR MESSAGE BOX--}}

                        							<div class="portlet box blue-hoki">
                        					<div class="portlet-title">
                        						<div class="caption font-dark">
                        						Edit Salary info
                        						</div>
                        					</div>
                        					<div class="portlet-body">


                										<div class="form-group">
                												<label class="control-label col-md-2">OverTime Hours:</label>
                												<div class="col-md-8 margin-bottom-10">
                												<label class="control-label">{{$payroll->overtime_hours}}</label>

                												</div>
                										</div>
                										<div class="form-group">
                												<label class="control-label col-md-2">Overtime Payment ( {{$loggedAdmin->company->currency_symbol}} ):</label>
                												<div class="col-md-8 margin-bottom-10">
                												<label class="control-label">{{$payroll->overtime_pay}}</label>

                												</div>
                										</div>
                										<div class="form-group">
                												<label class="control-label col-md-2">Basic Salary ( {{$loggedAdmin->company->currency_symbol}} ):</label>
                												<div class="col-md-8 margin-bottom-10">
                												<label class="control-label">{{number_format($payroll->basic, 2)}}</label>
                												</div>
                										</div>
														<div class="form-group">
																<label class="control-label col-md-2">Expense Claim( {{$loggedAdmin->company->currency_symbol}} ):</label>
																<div class="col-md-8 margin-bottom-10">
																<label class="control-label">{{number_format($payroll->expense, 2)}}</label>
																</div>
														</div>
                										<!--/span-->

                        					</div>
                        				</div>
                        				</div>
                			{{--Allowances--}}
                				<div class="col-md-6">
                						<div class="portlet box blue-hoki">
                							<div class="portlet-title">
                								<div class="caption font-dark">
                								Edit Allowances
                								</div>
                							</div>
                							<div class="portlet-body">

                							@foreach(json_decode($payroll->allowances) as $index=>$value)

                								<div class="form-group" id="allowance">
                											<label class="control-label col-md-2"></label>
                											<div class="col-md-4 margin-bottom-10">
                												<label class="control-label">{{$index}}  ( {{$loggedAdmin->company->currency_symbol}} )</label>

                											</div>
                											<div class="col-md-4  margin-bottom-10">
                												<label class="control-label">{{number_format($value, 2)}}</label>

                											</div>


                										</div>
                							@endforeach




                								</div>
                						</div>
                					</div>
                			{{--Allowances End--}}
                			{{--Deductions--}}
                				<div class="col-md-6">
                						<div class="portlet box blue-hoki">
                							<div class="portlet-title">
                								<div class="caption font-dark">
                								Edit Deductions
                								</div>
                							</div>
                							<div class="portlet-body">

                							@foreach(json_decode($payroll->deductions) as $index=>$value)

                								<div class="form-group" id="deduction">
                											<label class="control-label col-md-2"></label>
                											<div class="col-md-4 margin-bottom-10">
                												<label class="control-label">{{$index}}  ( {{$loggedAdmin->company->currency_symbol}} )</label>

                											</div>
                											<div class="col-md-4  margin-bottom-10">
                												<label class="control-label">{{number_format($value, 2)}}</label>
                											</div>

                										</div>
                							@endforeach





                							</div>
                							</div>
                						</div>
                			{{--Deductions End--}}
                			{{--Gross--}}
                				<div class="col-md-12">
                									<div class="portlet box blue-hoki">
                										<div class="portlet-title">
                											<div class="caption font-dark">
                											GROSS
                											</div>
                										</div>
                										<div class="portlet-body">


                											<div class="form-group">
                													<label class="control-label col-md-2">Total Allowances ( {{$loggedAdmin->company->currency_symbol}} )</label>
                													<div class="col-md-8 margin-bottom-10">
                														<label class="control-label">{{number_format($payroll->total_allowance, 2)}}</label>

                													</div>
                											</div>
                											<div class="form-group">
                													<label class="control-label col-md-2">Total Deductions ( {{$loggedAdmin->company->currency_symbol}} )</label>
                													<div class="col-md-8 margin-bottom-10">
                														<label class="control-label">{{number_format($payroll->total_deduction, 2)}}</label>

                													</div>
                											</div>
                											<div class="form-group">
                													<label class="control-label col-md-2">Net Salary ( {{$loggedAdmin->company->currency_symbol}} )</label>
                													<div class="col-md-8 margin-bottom-10">
                														<label class="control-label">{{number_format($payroll->net_salary, 2)}}</label>

                													</div>
                											</div>
                										</div>
                								</div>
                			 </div>
                			 {{--Gross End--}}



				</div>

{!!  Form::close()  !!}
	<!-- END FORM-->





			<!-- END PAGE CONTENT-->

@stop

@section('footerjs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
{!! HTML::script("assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js")!!}
{!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
{!! HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")!!}
<!-- END PAGE LEVEL PLUGINS -->


@stop
