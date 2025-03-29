@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css") !!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css") !!}
    {!! HTML::style("assets/global/plugins/icheck/skins/all.css") !!}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{ trans("core.addExpense") }}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.expenses.index') }}')">{{trans('pages.expenses.indexTitle')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">{{trans('pages.expenses.createTitle')}}</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->


            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-database font-dark"></i>{{trans('core.expenseDetails')}}
                    </div>
                    <div class="tools">
                    </div>
                </div>

                <div class="portlet-body form">
                {!! Form::open(array('route'=>"admin.expenses.store",'class'=>'form-horizontal ajax_form','method'=>'POST','files'=>true))!!}

                <!-- BEGIN FORM-->


                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.item')}} {{trans('core.name')}}: <span
                                        class="required">
                                        * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="item_name" id="item_name"
                                       placeholder="{{trans('core.item')}} {{trans('core.name')}}"
                                       value="{{ Input::old('item_name') }}">
                            </div>
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.purchase_from')}}
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="purchase_from"
                                       placeholder="{{trans('core.purchase_from')}}"
                                       value="{{ Input::old('purchase_from') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.date')}}:
                            </label>
                            <div class="col-md-6">
                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy"
                                     data-date-viewmode="years">
                                    <input type="text" class="form-control" name="purchase_date" readonly>
                                    <span class="input-group-btn">
                                                                   <button class="btn default" type="button"><i
                                                                               class="fa fa-calendar"></i></button>
                                                                   </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.price')}}:<span
                                        class="required">  * </span> {{$loggedAdmin->company->currency_symbol}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="price" id='price'
                                       placeholder="{{trans('core.price')}}" value="{{ Input::old('price') }}">
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.paidBy')}}:<span
                                        class="required">  * </span></label>

                            <div class="col-md-6">
                                <select class="form-control select2me" name="employee_id">
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->full_name}} (EmpId: {{ $employee->employeeID }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Attach Bill:</label>

                            <div class="col-md-6">
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
                                                                            {{trans('core.change')}}  </span>
                                                                           <input type="file" name="bill">
                                                                           </span>
                                        <a href="#" class="input-group-addon btn red fileinput-exists"
                                           data-dismiss="fileinput">
                                            {{trans('core.remove')}}  </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.status')}}:<span
                                        class="required"> * </span></label>

                            <div class="col-md-6">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" class="icheck"
                                               value="approved"
                                               checked="checked"> {{trans('core.approved')}} </label>
                                    <label class="radio-inline"><input type="radio" name="status"
                                                                       class="icheck"
                                                                       value="pending"> {{trans('core.pending')}}
                                    </label>
                                </div>
                            </div>
                        </div>


                        <!-- END FORM-->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="button" id="expenseCreate" class="btn green"
                                        onclick="ajaxCreateExpense()"><i class="fa fa-check"></i> {{trans('core.add')}}
                                </button>

                            </div>
                        </div>
                    </div>
                    {!!  Form::close() !!}
                </div>

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->



@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") !!}
    {!! HTML::script("assets/admin/pages/scripts/components-pickers.js") !!}
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js") !!}
    {!! HTML::script('assets/global/plugins/icheck/icheck.min.js') !!}
    {!! HTML::script('assets/js/ajaxform/jquery.form.min.js')!!}
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        jQuery(document).ready(function () {
            ComponentsPickers.init();
            $.fn.select2.defaults.set("theme", "bootstrap");
            $('.select2me').select2({
                placeholder: "Select",
                width: '100%',
                allowClear: false
            });
        });

        // Javascript function to update the company info and Bank Info
        function ajaxCreateExpense() {
            var url = "{{ route('admin.expenses.store') }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '.ajax_form',
                file: true,
            });
        }

    </script>


@stop
