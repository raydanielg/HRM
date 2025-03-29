@extends('admin.adminlayouts.adminlayout')

@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                {{$pageTitle}}
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span class="active"> {{trans('core.settings')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div id="load">

                {{--INLCUDE ERROR MESSAGE BOX--}}

                {{--END ERROR MESSAGE BOX--}}


            </div>
            <div class="portlet light bordered">

                <div class="portlet-body form">

                    <h3>Add stripe details to make billing work</h3>
                    <hr>
                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::model($setting, ['method' => 'PUT','class'=>'form-horizontal', 'id' => 'stripeSettings'])  !!}
                    <input type="hidden" name="type" value="stripeSetting">
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{ trans('core.stripeKey') }}: <span class="required">
                                        * {!! help_text("stripeKey") !!} </span>(<a
                                        href="https://dashboard.stripe.com/account/apikeys" target="_blank">Generate</a>)
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="stripe_key" placeholder="Stripe Key"
                                       value="{{ $setting->stripe_key }}">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.stripeSecret')}}:
                                <span class="required">
                                        * {!! help_text("stripeSecretKey") !!} </span>(<a
                                        href="https://dashboard.stripe.com/account/apikeys" target="_blank">Generate</a>)
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="stripe_secret"
                                       value="{{ $setting->stripe_secret }}" placeholder="Stripe Secret">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.stripeWebhookSecret')}}: <span
                                        class="required">
                                        * {!! help_text("stripeWebhookKey") !!} </span>


                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control margin-bottom-15" name="stripe_webhook_secret"
                                       value="{{ $setting->stripe_webhook_secret}}" placeholder="Stripe webhook secret">
                                <ul>
                                <li class="bmd-help"> Visit <a
                                            href="https://dashboard.stripe.com/account/webhooks"
                                            target="_blank">Generate</a> Add end point as <b> {{ route('admin.stripe.save_webhook')}}</b> and enter the webhook key generated</li>
                                    <li> Select event <b>invoice.payment_failed</b> and <b>invoice.payment_succeeded</b> while creating webhook.</li>
                                </ul>
                            </div>

                        </div>
                        <!------------------------- END FORM ----------------------->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="submit" onclick="stripeSetting();return false;"

                                        class="btn green">{{trans('core.btnUpdate')}}</button>

                            </div>
                        </div>
                    </div>
                    {!! Form::close()  !!}
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
@stop

@section('footerjs')

    <script>
        function stripeSetting() {
            var url = "{{ route('admin.settings.update', $setting->id) }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '#stripeSettings',
                data: $('#stripeSettings').serialize(),
            });
        }
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
