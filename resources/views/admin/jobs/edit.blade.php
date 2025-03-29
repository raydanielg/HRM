@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css") !!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")!!}
    {!! HTML::style("assets/global/plugins/typeahead/typeahead.css")!!}
    {!! HTML::style("assets/global/plugins/bootstrap-summernote/summernote.css")!!}
    <!-- BEGIN THEME STYLES -->

@stop


@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.jobs.editTitle")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{__('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.jobs.index') }}')">@lang("pages.jobs.indexTitle")</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("pages.jobs.editTitle")</span>
            </li>
        </ul>

    </div>            <!-- END PAGE HEADER-->            <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            {{--INLCUDE ERROR MESSAGE BOX--}}

            {{--END ERROR MESSAGE BOX--}}


            <div class="portlet light bordred">

                <div class="portlet-body form">

                    <!-- BEGIN FORM-->
                    {!! Form::open(['class'=>'form-horizontal ajax_form']) !!}


                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.position')}}: <span class="required">
								* </span>
                            </label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="typeahead_example_1" name="position"
                                       placeholder="{{trans('core.position')}}" value="{{ $job->position }}">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.description')}}: <span class="required">
								* </span>
                            </label>

                            <div class="col-md-6">
							<textarea class="form-control" id="description"
                                      name="description">{{ $job->description }}</textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.postedDate')}}
                            </label>

                            <div class="col-md-6">
                                <div class="input-group input-medium date date-picker" data-date-viewmode="years">
                                    <input type="text" class="form-control" name="posted_date" id="posted_date"
                                           data-date-format="dd-mm-yyyy" data-date-viewmode="years" readonly
                                           value="{{ $job->posted_date }}">
                                    <span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.lastDateToApply')}}
                            </label>

                            <div class="col-md-6">
                                <div class="input-group input-medium date2 ">
                                    <input type="text" class="form-control" name="last_date" id="last_date"
                                           data-date-format="dd-mm-yyyy" data-date-viewmode="years" readonly
                                           value="{{ $job->last_date }}">
                                    <span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.closeDate')}}
                            </label>

                            <div class="col-md-6">
                                <div class="input-group input-medium date1">
                                    <input type="text" class="form-control" name="close_date"
                                           data-date-format="dd-mm-yyyy"
                                           data-date-viewmode="years" id="close_date" readonly
                                           value="{{ $job->close_date }}">
                                    <span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.status')}}</label>

                            <div class="col-md-6">

                                <label class="radio-inline">
                                    <input type="radio" name="status" value="active"
                                           @if($job->status=='active') checked="checked" @endif>@lang("core.active")
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="inactive"
                                           @if($job->status=='inactive') checked="checked" @endif>@lang("core.inactive")
                                </label>


                            </div>
                        </div>


                        <!-- END FORM-->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">

                                <button class="btn green" onclick="ajaxUpdateJob({{$job->id}});return false;">
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
    {!! HTML::script("assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js")!!}
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-summernote/summernote.min.js")!!}
    {!! HTML::script("assets/global/plugins/typeahead/typeahead.bundle.min.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") !!}
    <script>

        $(document).ready(function () {
            $('#description').summernote({height: 300});
            $('#posted_date').datepicker();
            $('#last_date').datepicker();
            $('#close_date').datepicker();
        });


        var numbers = new Bloodhound({
            datumTokenizer: function (d) {
                return Bloodhound.tokenizers.whitespace(d.designation);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: {!! $designation !!}


        });

        // initialize the bloodhound suggestion engine
        numbers.initialize();

        // instantiate the typeahead UI
        if (App.isRTL()) {
            $('#typeahead_example_1').attr("dir", "rtl");
        }

        $('#typeahead_example_1').typeahead(null, {
            displayKey: 'designation',
            hint: (App.isRTL() ? false : true),
            source: numbers.ttAdapter()
        });

        function ajaxUpdateJob(id) {
            var url = "{{ route('admin.jobs.update',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                url: url,
                type: "PUT",
                data: $(".ajax_form").serialize(),
                container: ".ajax_form",
            });

        }
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
