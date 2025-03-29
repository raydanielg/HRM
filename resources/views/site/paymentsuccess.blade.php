@extends("site.app")
@section("title")
    Payment Success - {{ $setting->main_name }}
@endsection

@section("content")
    <section id="features">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">
                <h2>Payment Success!</h2>

                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Congratulations!</strong> Your payment was successful.</p>
                        <p>Here is your SnapHRM license number: <strong>{{ $license_number }}</strong></p>
                        <p>Please download you copy from link below:</p>
                        <br/>
                        <p><b>Download Link:</b> <a href="{{ route("download", ["license_number" => $license_number]) }}">{{ route("download", ["license_number" => $license_number]) }}</a></p>
                        <img src="{{ asset("assets/images/congrats.png") }}"/>
                        <p>Contact us at <a href="mailto:support@snaphrm.com">support@snaphrm.com</a> for assistance with installation on your server.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </section>
@endsection
@section("javascript")
    <script type="text/javascript">
        /* <![CDATA[ */
        goog_snippet_vars = function() {
            var w = window;
            w.google_conversion_id = 956230304;
            w.google_conversion_label = "rBnECIDts2IQoNX7xwM";
            w.google_remarketing_only = false;
        };
        // DO NOT CHANGE THE CODE BELOW.
        goog_report_conversion = function(url) {
            goog_snippet_vars();
            window.google_conversion_format = "3";
            window.google_is_call = true;
            var opt = new Object();
            opt.onload_callback = function() {
                if (typeof(url) != 'undefined') {
                    window.location = url;
                }
            }
            var conv_handler = window['google_trackConversion'];
            if (typeof(conv_handler) == 'function') {
                conv_handler(opt);
            }
        };
        /* ]]> */

        $(document).ready(function() {
            goog_report_conversion();
        });
    </script>
    <script type="text/javascript"
            src="//www.googleadservices.com/pagead/conversion_async.js">
    </script>

@endsection
