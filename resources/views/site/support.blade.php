@extends("site.app")
@section("title")
    Support - {{ $setting->main_name }}
@endsection

@section('css')
    <link href="{{ asset('assets/site/plugins/froiden-helper/helper.css') }}" rel="stylesheet">
@endsection

@section("content")
    <section id="features">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">
                <h2>Frequently Asked Questions (FAQs)</h2>

                <p>Please go through the following FAQs containing solutions to most common problems faced by our
                    customers.
                    You can submit a support request below if you cannot find solution to your problem in these
                    questions.</p>
                <p>&nbsp;</p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-wrap">
                            <div class="media">
                                <div class="parent pull-left">
                                    <ul class="nav nav-tabs nav-stacked">
                                        @foreach($faqCategories as $faqCategory)
                                            <li @if($loop->first) class="active" @endif><a
                                                        href="#tab_{{ $faqCategory->id }}" data-toggle="tab"
                                                        class="analistic-01">General
                                                    {{ $faqCategory->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="parent media-body">
                                    <div class="tab-content">
                                        @foreach($faqCategories as $faqCategory)
                                            <div class="tab-pane @if($loop->first) active @endif"
                                                 id="tab_{{ $faqCategory->id }}">
                                                <div class="media">

                                                    <div class="accordion">
                                                        <div class="panel-group" id="accordion_{{ $faqCategory->id }}">
                                                            @foreach($faqCategory->faq as $faq)
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading @if($loop->first) active @endif">
                                                                        <h3 class="panel-title">
                                                                            <a class="accordion-toggle"
                                                                               data-toggle="collapse"
                                                                               data-parent="#accordion_{{ $faqCategory->id }}"
                                                                               href="#collapse_{{ $faq->id }}">
                                                                                {{ $loop->iteration }}
                                                                                . {{ $faq->title }}
                                                                                <i class="fa fa-angle-right pull-right"></i>
                                                                            </a>
                                                                        </h3>
                                                                    </div>

                                                                    <div id="collapse_{{ $faq->id }}"
                                                                         class="panel-collapse collapse in">
                                                                        <div class="panel-body">
                                                                            <div class="media accordion-inner">
                                                                                {{ $faq->content_text }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div><!--/#accordion1-->
                                                    </div>


                                                </div>
                                            </div>
                                        @endforeach
                                    </div> <!--/.tab-content-->
                                </div> <!--/.media-body-->
                            </div> <!--/.media-->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <h2>Contact Us</h2>

                        <p>How can we help you? We will try to get back to you as soon as possible.</p>
                        <p>&nbsp;</p>

                        {{--@if (count($errors) > 0)--}}
                        {{--<div class="alert alert-danger">--}}
                        {{--<ul>--}}
                        {{--@foreach ($errors->all() as $error)--}}
                        {{--<li>{{ $error }}</li>--}}
                        {{--@endforeach--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--@endif--}}

                        <form class="contact-form" id="contact_form" method="post" action="">
                            <div id="alert"></div>
                            {!! Honeypot::generate('tts', 'tts_time') !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>I want help with:</label>
                                <select class="form-control" name="category">
                                    <option value="" disabled="disabled">— Choose a Category —</option>
                                    <option value="My Account">My Account</option>
                                    <option value="Billing">Billing</option>
                                    <option value="Feedback and Feature Requests">Feedback and Feature Requests</option>
                                    <option value="Something's Not Working">Something's Not Working</option>
                                    <option value="How do I...?">How do I...?</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Details of problem:</label>
                                <textarea name="details" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="button" name="submit" onclick="contactSubmit();return false;"
                                        class="btn btn-primary btn-lg">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h2>Email</h2>
                        <p>You can also get in touch with us on our email: <a
                                    href="mailto:support{{ $setting->email }}">{{ $setting->email }}</a>.</p>
                        <p>&nbsp;</p>
                        <h2>Address</h2>

                        <p>
                            {!! $setting->address !!}
                            .</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="clearfix"></div>

    </section>
@endsection
@section('javascript')
    <script src="{{asset('assets/site/plugins/froiden-helper/helper.js')}}"></script>
    <script type="text/javascript">
        function contactSubmit() {
            $.easyAjax({
                url: "{!! route('contact.submit') !!}",
                type: "POST",
                data: $("#contact_form").serialize(),
                container: "#contact_form",
                messagePosition: "inline",
                removeElements: true
            });
        }
    </script>
@endsection
