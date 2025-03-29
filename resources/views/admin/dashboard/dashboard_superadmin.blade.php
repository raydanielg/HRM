@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/fullcalendar/fullcalendar.min.css")!!}
    <!-- BEGIN THEME STYLES -->

@stop
@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{ trans('pages.superAdminDashboard.title') }}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <span class="active">{{ trans('pages.superAdminDashboard.title') }}</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->


    {!!   $setting->set_smtp_message !!}

    @php($updateVersionInfo = \Froiden\Envato\Functions\EnvatoUpdate::updateVersionInfo())
    @if(isset($updateVersionInfo['lastVersion']))
        <div class="note note-info row">
            <div class="col-md-10"><i class="fa fa-gift"></i> @lang('core.newUpdate') <label
                        class="label label-success">{{ $updateVersionInfo['lastVersion'] }}</label></div>
            <div class="col-md-2">
                <a href="javascript:;" onclick="loadView('{{route('admin.updateVersion.index')}}')"
                   class="btn btn-success btn-small">@lang('core.updateNow')
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>

    @endif
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat green">
                <div class="visual">
                    <i class="fa fa-desktop"></i>
                </div>
                <div class="details">
                    <div class="number count">
                        {{$loggedAdmin->company_count}}
                    </div>
                    <div class="desc">
                        {{ trans('core.totalCompany') }}
                    </div>
                </div>
                <a class="more" href="{{route('admin.companies.index') }}">
                    {{ trans('core.viewMore') }} <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat red-intense">
                <div class="visual">
                    <i class="fa fa-desktop"></i>
                </div>
                <div class="details">
                    <div class="number count">
                        {{ $company_lists->count() }}

                    </div>
                    <div class="desc">
                        {{ trans('core.weeklyActiveCompany') }}
                    </div>
                </div>
                <a class="more" href="{{route('admin.licenses.index') }}">
                    {{ trans('core.viewMore') }} <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat yellow-crusta">
                <div class="visual">
                    <i class="fa fa-usd"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <i class="fa fa-{{ strtolower($currency) }}"></i> <span class="count">{{ $total_earning }}</span>
                    </div>

                    <div class="desc">
                        Total Income
                    </div>
                </div>
                <a class="more" href="{{route('admin.invoices.index') }}">
                    {{ trans('core.viewMore') }} <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-th-large font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">@lang("core.weeklyActiveCompany")</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                        <ul class="feeds">

                            @foreach($company_lists as $company_data)
                                <li>
                                    <div class="col1">
                                        {!!  HTML::image($company_data->logo_image_url,'Logo',['class'=>'logo-default','height'=>'20px']) !!}
                                        <div class="cont-col2">
                                            <div class="desc"><a
                                                        onclick="loadView('{{route('admin.companies.edit', [$company_data->id])}}')">{{$company_data->company_name}}</a>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col2">
                                        <div class="date">{{$company_data->last_in_words}}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="scroller-footer">
                        <div class="btn-arrow-link pull-right">
                            <a onclick="loadView('{{route('admin.companies.index')}}')">See All Records</a>
                            <i class="icon-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-blue">
                        <i class="fa fa-line-chart font-blue"></i>
                        {{ trans('core.companyRegister') }}
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12" id="earningReport">
            <div class="portlet light bordered ">
                <div class="portlet-title">
                    <div class="caption font-blue">
                        {{ $currency_symbol }}{{ trans('core.earningReport') }}
                    </div>
                    <div class="btn-group pull-right">
                        <span class="control-label"><strong>Filter By @lang('core.year'):</strong></span>
                        {!!  Form::select('employee_id', $earningYearFilter ,'all',['class' => 'form-control input-sm input-small input-inline ','id'=>'filterYear','data-placeholder'=> trans("core.selectAnEmployee").'...'])  !!}
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="earningChart" style="width: 100%; height: 400px; margin: 0 auto">

                    </div>
                </div>
            </div>

        </div>
    </div>

@stop

@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->

    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js")!!}
    {!! HTML::script("assets/pages/scripts/dashboard.min.js")!!}
    {!! HTML::script("assets/admin/pages/scripts/components-dropdowns.js")!!}
    {!! HTML::script("assets/global/plugins/moment.min.js")!!}
    {!! HTML::script("assets/global/plugins/fullcalendar/fullcalendar.min.js")!!}
    {!! HTML::script("assets/global/plugins/fullcalendar/lang-all.js")!!}
    {!! HTML::script("assets/global/plugins/highcharts/js/highcharts.js")!!}
    {!! HTML::script("assets/global/plugins/highcharts/js/modules/exporting.js")!!}





    <script>
        $('.count').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 2000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    </script>
    <script>
        $(function () {
            $('#container').highcharts({
                title: {
                    text: 'Companies Registered ({{ trans('core.'.$monthName) }})',
                    x: -20 //center
                },
                xAxis: {
                    categories: [
                        '{{ trans('core.'.$monthName) }}'
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Companies'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ''
                },
                legend: {
                    layout: 'vertical',
                    align: 'center',
                    verticalAlign: 'bottom',
                    borderWidth: 0
                },
                series: [{
                    name: 'No. of Companies',
                    data: {!! json_encode($graph_data)!!}
                }]
            });
        });
    </script>
    <!-- END PAGE LEVEL PLUGINS -->

    <script>
        $(document).ready(
            initChart([{!! $earning !!} ], new Date().getFullYear())
        );

        function initChart(earning, year) {

            $('#earningChart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '{{ trans('core.yearlyEarningReport') }} ' + year
                },
                xAxis: {
                    categories: [
                        '{{ trans('core.jan') }}',
                        '{{ trans('core.feb') }}',
                        '{{ trans('core.mar') }}',
                        '{{ trans('core.apr') }}',
                        '{{ trans('core.may') }}',
                        '{{ trans('core.june') }}',
                        '{{ trans('core.july') }}',
                        '{{ trans('core.aug') }}',
                        '{{ trans('core.sept') }}',
                        '{{ trans('core.oct') }}',
                        '{{ trans('core.nov') }}',
                        '{{ trans('core.dec') }}'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        useHTML: true,
                        text: '{{ trans('core.earning') }} ({{ $currency_symbol }})'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} {{ $currency_symbol }}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return Highcharts.numberFormat(this.y, 2);
                            }
                        },
                    }

                },
                series: [{
                    name: '{{ $currency_symbol }} {{  trans('core.earning') }}',
                    data: earning

                }]
            });
        }

        $('#filterYear').select2().on("select2:select", function (e) {

            var year = $('#filterYear').val();
            var url = "{{ route('admin.earning.report',':year') }}";
            url = url.replace(':year', year);
            $.ajax({
                type: "get",
                url: url,
                dataType: 'json',
                data: {"year": $('#filterYear').val()},

                beforeSend: function () {
                    $("#earningChart").html('<div style="margin-left:48%">{!!  HTML::image('assets/loader.gif') !!}</div>');
                },
                success: function (response) {
                    if (response.success == "success") {
                        $("#earningChart").html('');

                        var array = response.earningReport.split(',');
                        array.forEach(function (item, i) {
                            if (item == "''") {
                                array[i] = '';
                            } else {
                                array[i] = parseFloat(item)
                            }
                        });
                        console.log(array);
                        initChart(array, year);
                    }
                }

            });
        });

    </script>
@stop
