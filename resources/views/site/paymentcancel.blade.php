@extends("site.app")
@section("title")
    Payment Failed - {{ $setting->main_name }}
@endsection

@section("content")
    <section id="features">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">
                <h2>Payment Failed</h2>

                <div class="row">
                    <div class="col-md-12">
                        <p>Your payment could not be processed successfully. If you cancelled the payment, you can go back to <a href="{{ route("signup") }}">sign up page</a> to try paying again.</p>
                        <p>If you paid but got error here, please contact us at <a href="mailto:support@snaphrm.com">support@snaphrm.com</a> with your email ID and we will assist you as soon as possible.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </section>
@endsection
