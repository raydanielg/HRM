@extends("site.app")
@section("title")
    Sign Up - {{ $setting->main_name }}
@endsection
@section('css')
    <link href="{{ asset('assets/plugins/froiden-helper/helper.css') }}" rel="stylesheet">
@endsection
@section("content")
    <section id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2" id="sign-up-form">
                    <h2 id="heading">Sign Up for {{ $setting->main_name }}</h2>

                    <div class="row">
                        <div class="col-md-12">

                            <form class="hosted-form" method="post" action="" role="form" id="signUpForm">
                                <div class="row">
                                    <div id="alert"></div>
                                    {!! Honeypot::generate('snaphrm', 'snap_time') !!}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                    <div class="form-group col-md-12">
                                        <label for="name">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="email">Contact Number</label>
                                        <input type="number" class="form-control" id="contact" name="contact" placeholder="" value="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="company">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="">
                                    </div>
                                    <h2 style="margin-left: 14px;">Login Details</h2>
                                    <div class="form-group col-md-12" id="domainContainer">
                                        <label for="company">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12" id="passwordContainer">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="" required="">
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12" id="passwordContainer">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="" required="">
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12" id="confirmPasswordContainer">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">By signing up or purchasing, you agree to our <a href="{{ route("termsOfService") }}">Terms of Service</a> and <a href="{{ route("privacyPolicy") }}">Privacy Policy</a>.<br/><br/></div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-lg" onclick="newSignUpAdmin();" id="submitButton">Sign Up</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-lg-offset-2" id="sign-up-success" style="display: none; margin-top: 50px;">
                    <div class="alert alert-success">
                        Registration successful. Please check your email and verify your email address.
                    </div>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>
    </section>
@endsection
@section("javascript")
    <script src="{{asset('assets/site/plugins/froiden-helper/helper.js')}}"></script>
<script type="text/javascript">
    function newSignUpAdmin() {
        $.easyAjax({
            url: "{!! route('signup.submit') !!}",
            type: "POST",
            data: $("#signUpForm").serialize(),
            container: "#signUpForm",
            messagePosition: "inline",
            removeElements: true,
            success: function (response) {
                if (response.status != "fail") {
                    $('#sign-up-form').fadeOut(100);
                    $('#sign-up-success').fadeIn();
                }
            }
        });
    }
</script>

@endsection