@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")!!}
    {!! HTML::style("assets/global/plugins/typeahead/typeahead.css")!!}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{trans('core.editAward')}}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.awards.index') }}')">{{trans('pages.awards.indexTitle')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">{{trans('pages.awards.editTitle')}}</span>
            </li>
        </ul>

    </div>            <!-- END PAGE HEADER-->            <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div id="load">
                {{--INLCUDE ERROR MESSAGE BOX--}}

                {{--END ERROR MESSAGE BOX--}}
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red">
                        <i class="fa fa-edit font-red"></i>{{ trans('core.awardDetails') }}
                    </div>
                    <div class="tools"></div>
                </div>

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::model($award, ['method' => 'PATCH', 'class'=>'form-horizontal ajax_form'])  !!}

                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.award_name')}} {!! help_text("award_name") !!}
                                <span class="required">
                                * </span>
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="award_name" id="award_name"
                                       placeholder="{{ trans('core.award_name') }}" value="{{ $award->award_name }}">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{ trans('core.gift') }}  {!! help_text("awardGift") !!}
                                <span class="required">
                                * </span>
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="gift" id="gift"
                                       placeholder="{{trans('core.gift')}}"
                                       value="{{ $award->gift }}">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.cash_price')}}
                                ({{$loggedAdmin->company->currency_symbol}})</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="cash_price"
                                       placeholder="{{trans('core.cash_price')}}" value="{{ $award->cash_price }}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.employee')}} {{trans('core.name')}}</label>

                            <div class="col-md-6">
                                <select class="form-control select2me" name="employee_id">
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}"
                                                @if($employee->id==$award->employee_id)selected='selected'@endif >{{$employee->full_name}} (EmpId: {{ $employee->employeeID }})</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.month')}}</label>

                            <div class="col-md-3">
                                <select class="form-control select2me" name="month">
                                    <option value="" selected="selected">{{trans('core.month')}}</option>
                                    <option value="january"
                                            @if($award->month=='january')selected='selected'@endif >{{trans('core.jan')}}</option>
                                    <option value="february"
                                            @if($award->month=='february')selected='selected'@endif>{{trans('core.feb')}}</option>
                                    <option value="march"
                                            @if($award->month=='march')selected='selected'@endif>{{trans('core.mar')}}</option>
                                    <option value="april"
                                            @if($award->month=='april')selected='selected'@endif>{{trans('core.apr')}}</option>
                                    <option value="may"
                                            @if($award->month=='may')selected='selected'@endif>{{trans('core.may')}}</option>
                                    <option value="june"
                                            @if($award->month=='june')selected='selected'@endif>{{trans('core.june')}}</option>
                                    <option value="july"
                                            @if($award->month=='july')selected='selected'@endif>{{trans('core.july')}}</option>
                                    <option value="august"
                                            @if($award->month=='august')selected='selected'@endif>{{trans('core.aug')}}</option>
                                    <option value="september"
                                            @if($award->month=='september')selected='selected'@endif>{{trans('core.sept')}}</option>
                                    <option value="october"
                                            @if($award->month=='october')selected='selected'@endif>{{trans('core.oct')}}</option>
                                    <option value="november"
                                            @if($award->month=='november')selected='selected'@endif>{{trans('core.nov')}}</option>
                                    <option value="december"
                                            @if($award->month=='december')selected='selected'@endif>{{trans('core.dec')}}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">

                            <label class="col-md-2 control-label">{{trans('core.year')}}</label>

                            <div class="col-md-3">
                                {!!  Form::selectYear('year', 2017, date('Y')+1,$award->year,['class'=>'form-control select2me']) !!}
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="button" id="updateAward"
                                        class=" btn green" onclick="ajaxUpdateAward({{$award->id}});return false;"><i
                                            class="fa fa-check"></i> {{trans('core.btnUpdate')}}</button>

                            </div>
                        </div>
                    </div>
                {!!  Form::close() !!}<!------------------------- END FORM ----------------------->

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->

        </div>
    </div>            <!-- END PAGE CONTENT-->



@stop

@section('footerjs')

    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/select2/js/select2.js")!!}
    {!! HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")!!}
    {!! HTML::script("assets/global/plugins/typeahead/typeahead.bundle.min.js")!!}
    {!! HTML::script('assets/js/ajaxform/jquery.form.min.js')!!}
    <script>
        function ajaxUpdateAward(id) {
            var url = "{{ route('admin.awards.update',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "POST",
                data: $(".ajax_form").serialize(),
                container: ".ajax_form",
            });
        }


        var handleTwitterTypeahead = function () {
            // Example #1
            // instantiate the bloodhound suggestion engine
            var numbers = new Bloodhound({
                datumTokenizer: function (d) {
                    return Bloodhound.tokenizers.whitespace(d.num);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: [
                    {num: '{{trans('core.employeeOfMonth')}}'},
                    {num: '{{trans('core.workAppreciation')}}'}
                ]
            });

            // initialize the bloodhound suggestion engine
            numbers.initialize();

            // instantiate the typeahead UI

            $('#typeahead_example_1').typeahead(null, {
                displayKey: 'num',
                hint: (App.isRTL() ? false : true),
                source: numbers.ttAdapter()
            });


        };

        handleTwitterTypeahead();

        $.fn.select2.defaults.set("theme", "bootstrap");
        $('.select2me').select2({
            placeholder: "Select",
            width: '100%',
            allowClear: false
        });
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
