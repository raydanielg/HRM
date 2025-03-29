@extends("site.app")
@section("title")
    Pricing Plans - {{ $setting->main_name }}
@endsection
@section('css')
    <link href="{{ asset('assets/site/css/pricing.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/site/css/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/site/css/components.css?v=1') }}" rel="stylesheet">
    <style>
        .loader-main {
            position: fixed;
            z-index: 9999;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(256, 256, 256, 0.5);
        }

        .loader-main i {
            position: absolute;
            top: 49%;
            left: 49%;
        }

        .loader-inside {
            position: absolute;
            z-index: 9999;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(256, 256, 256, 0.5);
        }

        .loader-inside i {
            position: absolute;
            top: 49%;
            left: 49%;
        }

        #contents h2 {
            color: #fff;
            font-weight: 500;
        }

        h3 {
            color: unset !important;
        }

        .text-left {
            font-size: 17px;
            margin-top: 15px;
            font-weight: 500;
            line-height: 0;
        }
    </style>
@endsection
@section("content")
    <section id="features">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">
                <div class="">
                    <h2>Pricing Plans</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="">We offer multiple plans to suit your needs.</p>
                            {{--<p><small><strong>Note: </strong> Discounted rates are under <span style="color: #EF4836; font-weight: bold">Christmas Offer</span> and valid until <strong>10th January, 2015</strong> only.</small></p>--}}
                            <p>&nbsp;</p>
                            <div class="portlet-body">
                                <div class="pricing-content-1" id="contents">

                                    <div class="row">
                                        <h3>Monthly Plans</h3>
                                        <?php $count = 0; ?>
                                        @foreach($plans as $plan)
                                            <?php $count += 1; ?>
                                            <?php if ($count == 5) { ?>
                                    </div>
                                    <p>&nbsp;</p>
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-4">
                                            <div class="price-column-container border-active">
                                                <div class="price-table-head bg-blue">
                                                    <h2 class="no-margin">{{ $plan->plan_name }}</h2>
                                                </div>
                                                <div class="arrow-down border-top-blue"></div>
                                                <div class="price-table-pricing">
                                                    <h3>
                                                        <sup class="price-sign">{{ $setting->currency_symbol }}</sup>{{ $plan->annual_price }}</h3>
                                                    <p>per year</p>
                                                </div>
                                                <div class="price-table-content">
                                                    <div class="row mobile-padding">
                                                        <div class="col-xs-3 text-right mobile-padding"
                                                             style="line-height: 2;">
                                                            <i class="icon-user"></i>
                                                        </div>
                                                        <div class="col-xs-9 text-left mobile-padding">{{ $plan->start_user_count }}
                                                            - {{ $plan->end_user_count }} Employees
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="arrow-down arrow-grey"></div>
                                                <div class="price-table-footer">
                                                    <a href="{{ route('signup') }}"
                                                       class="btn grey-salsa btn-outline sbold uppercase price-button subscription-button">Register</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else { ?>
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
                                                </div>
                                                <div class="price-table-content">
                                                    <div class="row mobile-padding">
                                                        <div class="col-xs-3 text-right mobile-padding"
                                                             style="line-height: 2;">
                                                            <i class="icon-user"></i>
                                                        </div>
                                                        <div class="col-xs-9 text-left mobile-padding">{{ $plan->start_user_count }}
                                                            - {{ $plan->end_user_count }} Employees
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="arrow-down arrow-grey"></div>
                                                <div class="price-table-footer">
                                                    <a href="{{ route('signup') }}"
                                                       class="btn grey-salsa btn-outline sbold uppercase price-button subscription-button">Register</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        @endforeach
                                    </div>
                                    <p>&nbsp;</p>
                                    <div class="row">
                                        <h3>Yearly Plans</h3>
                                        <?php $count = 0; ?>
                                        @foreach($plans as $plan)
                                            <?php $count += 1; ?>
                                            <?php if ($count == 5) { ?>
                                    </div>
                                    <p>&nbsp;</p>
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-4">
                                            <div class="price-column-container border-active">
                                                <div class="price-table-head bg-blue">
                                                    <h2 class="no-margin">{{ $plan->plan_name }}</h2>
                                                </div>
                                                <div class="arrow-down border-top-blue"></div>
                                                <div class="price-table-pricing">
                                                    <h3>
                                                        <sup class="price-sign">{{ $setting->currency_symbol }}</sup>{{ $plan->annual_price }}</h3>
                                                    <p>per annum</p>
                                                </div>
                                                <div class="price-table-content">
                                                    <div class="row mobile-padding">
                                                        <div class="col-xs-3 text-right mobile-padding"
                                                             style="line-height: 2;">
                                                            <i class="icon-user"></i>
                                                        </div>
                                                        <div class="col-xs-9 text-left mobile-padding">{{ $plan->start_user_count }}
                                                            - {{ $plan->end_user_count }} Employees
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="arrow-down arrow-grey"></div>
                                                <div class="price-table-footer">
                                                    <a href="{{ route('signup') }}"
                                                       class="btn grey-salsa btn-outline sbold uppercase price-button subscription-button">Register</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <div class="col-md-3">
                                            <div class="price-column-container border-active">
                                                <div class="price-table-head bg-blue">
                                                    <h2 class="no-margin">{{ $plan->plan_name }}</h2>
                                                </div>
                                                <div class="arrow-down border-top-blue"></div>
                                                <div class="price-table-pricing">
                                                    <h3>
                                                        <sup class="price-sign">{{ $setting->currency_symbol }}</sup>{{ $plan->annual_price }}</h3>
                                                    <p>per annum</p>
                                                </div>
                                                <div class="price-table-content">
                                                    <div class="row mobile-padding">
                                                        <div class="col-xs-3 text-right mobile-padding"
                                                             style="line-height: 2;">
                                                            <i class="icon-user"></i>
                                                        </div>
                                                        <div class="col-xs-9 text-left mobile-padding">{{ $plan->start_user_count }}
                                                            - {{ $plan->end_user_count }} Employees
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="arrow-down arrow-grey"></div>
                                                <div class="price-table-footer">
                                                    <a href="{{ route('signup') }}"
                                                       class="btn grey-salsa btn-outline sbold uppercase price-button subscription-button">Register</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        @endforeach
                                    </div>

                                    <p>&nbsp;</p>
                                    <div class="col-lg-12 text-center">
                                        <hr class="primary"/>
                                        <h1 class="section-heading" style="color:#000">More than {{ $max_users }}
                                            employees?</h1>
                                        <h2><a href="{{ route('support') }}">Contact us for a custom quote</a></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </section>
@endsection
