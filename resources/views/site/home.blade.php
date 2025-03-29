@extends("site.app")
@section("title")
    HRM - Cloud HR Software for Small and Medium Businesses
@endsection

@section("css")
    <style type="text/css">
        .videoWrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            padding-top: 25px;
            height: 0;
        }
        .videoWrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
@section("content")

    <section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <div class="carousel-inner">
                <div class="item active" style="background-image: url({{ asset('assets/site/images/slider/dashboard_home_1600.jpg') }});">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1" style="text-shadow: 0 3px 6px rgba(0,0,0,0.2)">A Complete HR Management Solution that delivers</h1>
                                    <h2 class="animation animated-item-2" style="text-shadow: 0 3px 6px rgba(0,0,0,0.2); margin: 18px 0; font-weight: 400;">Over 10,000 companies worldwide trust {{ $setting->main_name }}</h2>
                                    <form id="sign-up-form-1" method="post" class="form-inline animation animated-item-3" action="{{ route("signup") }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control input-lg" required="required" placeholder="Your Email ID"/>
                                        </div>
                                        <input type="submit" name="submit" class="input-lg btn btn-primary" value="Try for FREE!"/>
                                    </form>
                                    <h2 class="animation animated-item-2">No Credit Card required!</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
    </section><!--/#main-slider-->

    {{--<section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="center">
                        <h2>Watch Demo Video</h2>
                        <p class="lead">Watch SnapHRM in action and see for yourself how simple and easy it can be to do your daily tasks.</p>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <div class="videoWrapper">
                                    <iframe src="https://www.youtube.com/embed/5qc0ZzdcfTQ" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>--}}
    <section id="feature" >
        <div class="container">
           <div class="center wow fadeInDown">
                <h2>Why you will <i class="fa fa-heart"></i> {{ $setting->main_name }}</h2>
                <!-- <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p> -->
            </div>

            <div class="row">
                <div class="features">
                    <div class="col-md-6 col-sm-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-{{ strtolower($setting->currency) }}"></i>
                            <h2>Pay Fixed Monthly</h2>
                            <h3>Don't pay per employee and skyrocket your monthly bills.</h3>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-6 col-sm-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-thumbs-o-up"></i>
                            <h2>Easy to Use</h2>
                            <h3>Get started straightway and save yourself from spending hours figuring out how to do basic tasks</h3>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-6 col-sm-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-mobile"></i>
                            <h2>Mobile Friendly</h2>
                            <h3>Access from any device - HRM works seamlessly on desktop, mobile and tablet</h3>
                        </div>
                    </div><!--/.col-md-4-->


                    <div class="col-md-6 col-sm-12 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                        <div class="feature-wrap">
                            <i class="fa fa-rocket"></i>
                            <h2>Ever Improving</h2>
                            <h3>Our constant effort to make HRM better gives you new features regularly without any extra cost</h3>
                        </div>
                    </div><!--/.col-md-4-->
                </div><!--/.services-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#feature-->



    <section id="partner">
        <div class="container">
            <div class="center">
                <h2>Our Customers</h2>
                <p class="lead">Thousands of companies, from small businesses to enterprises use {{ $setting->main_name }} everyday.</p>
            </div>

            {{--<div class="partners">
                <div class="row">
                    <div class="col-md-offset-1 col-md-2 col-sm-4 col-xs-6 text-center" style="height: 100px"> <img class="img-responsive center-block" src="{{ asset('assets/site/images/partners/partner1.png') }}"></div>
                    <div class="col-md-2 col-sm-4 col-xs-6 text-center" style="height: 100px"> <img class="img-responsive center-block" src="{{ asset('assets/site/images/partners/partner2.png') }}"></div>
                    <div class="col-md-2 col-sm-4 col-xs-6 text-center" style="height: 100px"> <img class="img-responsive center-block" src="{{ asset('assets/site/images/partners/partner3.png') }}"></div>
                    <div class="col-md-2 col-sm-4 col-xs-6 text-center" style="height: 100px"> <img class="img-responsive center-block" src="{{ asset('assets/site/images/partners/partner4.png') }}"></div>
                    <div class="col-md-2 col-sm-4 col-xs-6 text-center" style="height: 100px"> <img class="img-responsive center-block" src="{{ asset('assets/site/images/partners/partner5.png') }}"></div>
                </div>
            </div>--}}
        </div><!--/.container-->
    </section><!--/#partner-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="center">
                        <h2>Get started today</h2>
                        <p class="lead">Sign Up and start using HRM for <b>FREE!</b> <em>No credit card required.</em></p>
                        <form id="sign-up-form-1" method="post" class="form-inline" action="{{ route("signup") }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control input-lg" required="required" placeholder="Your Email ID"/>
                            </div>
                            <input type="submit" name="submit" class="input-lg btn btn-primary" value="Sign Up"/>
                        </form></div>
                </div>
            </div>
        </div>
    </section>
    <img class="img-responsive" src="{{ asset('assets/site/images/dashboard_bottom_1600_1.jpg') }}" width="100%" />
@endsection
