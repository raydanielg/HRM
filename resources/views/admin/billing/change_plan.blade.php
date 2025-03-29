@extends('admin.adminlayouts.adminlayout')

@section('head')
{!! HTML::style('assets/admin/pages/css/pricing.css')!!}

@stop


@section('mainarea')


        <!-- BEGIN PAGE HEADER-->
<div class="page-head"><div class="page-title"><h1>
            @lang("pages.billing.plans")
        </h1></div></div>
<div class="page-bar">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">@lang("pages.billing.plans")</span>
        </li>

    </ul>

</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="page-content-inner">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Monthly Plans</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="pricing-content-1">
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="col-md-3">
                                <div class="price-column-container border-active">
                                    <div class="price-table-head bg-blue">
                                        <h2 class="no-margin">{{ $plan->plan_name }}</h2>
                                    </div>
                                    <div class="arrow-down border-top-blue"></div>
                                    <div class="price-table-pricing">
                                        <h3>
                                            <sup class="price-sign">{{ $setting->currency_symbol }}</sup>{{ $plan->monthly_price }}</h3>
                                        <p>per month</p>
                                        @if($loggedAdmin->company->subscriptionPlan && $loggedAdmin->company->subscriptionPlan->id == $plan->id && $loggedAdmin->company->package_type == 'monthly')
                                            <div class="price-ribbon">Selected</div>
                                        @endif
                                    </div>
                                    <div class="price-table-content">
                                        <div class="row mobile-padding">
                                            <div class="col-xs-3 text-right mobile-padding">
                                                <i class="icon-user"></i>
                                            </div>
                                            <div class="col-xs-9 text-left mobile-padding">{{ $plan->start_user_count }} - {{ $plan->end_user_count }} Users</div>
                                        </div>
                                    </div>
                                    <div class="arrow-down arrow-grey"></div>
                                    <form action="{{ route('admin.billing.stripe_payment') }}" method="POST">
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="type" value="monthly">
                                        {{ csrf_field() }}
                                        <script
                                                src="https://checkout.stripe.com/checkout.js"
                                                class="stripe-button d-flex flex-wrap justify-content-between align-items-center"
                                                data-email="{{ $loggedAdmin->company->email }}"
                                                data-key="{{ config('services.stripe.key') }}"
                                                data-amount="{{ round($plan->monthly_price) * 100 }}"
                                                data-button-name="Choose Plan"
                                                data-description="Payment through debit card."
                                                data-image="{{ $setting->logo_image_url }}"
                                                data-locale="auto"
                                                data-currency="{{ $setting->currency}}">
                                        </script>
                                        <script>
                                            // Hide default stripe button, be careful there if you
                                            // have more than 1 button of that class

                                            var buttons = document.getElementsByClassName("stripe-button-el");
                                            for (var i = 0; i < buttons.length; i++) {
                                                buttons[i].style.display = 'none'; //second console output
                                            }

                                        </script>
                                        @if(round($plan->monthly_price) > 0)
                                            <div class="price-table-footer">
                                                @if($loggedAdmin->company->subscriptionPlan && $loggedAdmin->company->subscriptionPlan->id == $plan->id && $loggedAdmin->company->package_type == 'monthly')
                                                    -
                                                @else
                                                    <button type="submit" class="btn grey-salsa btn-outline sbold uppercase price-button">Subscribe</button>
                                                @endif
                                            </div>
                                        @else
                                            <div class="price-table-footer">
                                                -
                                            </div>
                                        @endif
                                    </form>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="page-content-inner">
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Yearly Plans</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="pricing-content-1">
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="col-md-3">
                                    <div class="price-column-container border-active">
                                        <div class="price-table-head bg-blue">
                                            <h2 class="no-margin">{{ $plan->plan_name }}</h2>
                                        </div>
                                        <div class="arrow-down border-top-blue"></div>
                                        <div class="price-table-pricing">
                                            <h3>
                                                <sup class="price-sign">{{ $setting->currency_symbol }}</sup>{{ $plan->annual_price }}</h3>
                                            <p>per year</p>
                                            @if($loggedAdmin->company->subscriptionPlan && $loggedAdmin->company->subscriptionPlan->id == $plan->id && $loggedAdmin->company->package_type == 'annual')
                                                <div class="price-ribbon">Selected</div>
                                            @endif
                                        </div>
                                        <div class="price-table-content">
                                            <div class="row mobile-padding">
                                                <div class="col-xs-3 text-right mobile-padding">
                                                    <i class="icon-user"></i>
                                                </div>
                                                <div class="col-xs-9 text-left mobile-padding">{{ $plan->start_user_count }} - {{ $plan->end_user_count }} Users</div>
                                            </div>
                                        </div>
                                        <div class="arrow-down arrow-grey"></div>
                                        <div class="price-table-footer">
                                                <form action="{{ route('admin.billing.stripe_payment') }}" method="POST">
                                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                                    <input type="hidden" name="type" value="annual">
                                                    {{ csrf_field() }}
                                                    <script
                                                            src="https://checkout.stripe.com/checkout.js"
                                                            class="stripe-button d-flex flex-wrap justify-content-between align-items-center"
                                                            data-email="{{ $loggedAdmin->company->email }}"
                                                            data-key="{{ config('services.stripe.key') }}"
                                                            data-amount="{{ round($plan->annual_price) * 100 }}"
                                                            data-button-name="Choose Plan"
                                                            data-description="Payment through debit card."
                                                            data-image="{{ asset('uploads/company_logo/'.$loggedAdmin->company->logo) }}"
                                                            data-locale="auto"
                                                            data-currency="{{ $setting->currency_symbol}}">
                                                    </script>
                                                    <script>
                                                        // Hide default stripe button, be careful there if you
                                                        // have more than 1 button of that class

                                                        var buttons = document.getElementsByClassName("stripe-button-el");
                                                        for (var i = 0; i < buttons.length; i++) {
                                                            buttons[i].style.display = 'none'; //second console output
                                                        }

                                                    </script>
                                                    @if(round($plan->annual_price) > 0)
                                                        <div class="price-table-footer">
                                                            @if($loggedAdmin->company->subscriptionPlan && $loggedAdmin->company->subscriptionPlan->id == $plan->id && $loggedAdmin->company->package_type == 'annual')
                                                                -
                                                            @else
                                                                <button type="submit" class="btn grey-salsa btn-outline sbold uppercase price-button">Subscribe</button>
                                                            @endif
                                                        </div>
                                                     @else
                                                        <div class="price-table-footer">
                                                            -
                                                        </div>
                                                    @endif
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop



@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script('assets/global/plugins/uniform/jquery.uniform.min.js')!!}
    {!! HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") !!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/responsive/dataTables.responsive.js")!!}
    {!! HTML::script("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.js")!!}
    {!! HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")!!}
    {!! HTML::script("assets/global/plugins/select2/js/select2.js")!!}
    {!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')!!}
    {!! HTML::script('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')!!}
    {!! HTML::script('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')!!}




@stop
