@extends("site.app")
@section("title")
    Support - {{ $setting->main_name }}
@endsection

@section("content")
    <section id="features">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">
                <h2>Thank You!</h2>
                <p>Thank you for submitting your request. We will get back to you as soon as possible.</p>
                <p>&nbsp;</p>
                {{--<img src="{{ asset("assets/site/images/thankyou.jpg") }}" class="img-responsive"/>--}}

            </div>
        </div>

        <div class="clearfix"></div>

    </section>
@endsection
