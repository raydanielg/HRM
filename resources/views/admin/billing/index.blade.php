@extends('admin.adminlayouts.adminlayout')

@section('head')
<!-- BEGIN PAGE LEVEL STYLES -->
{!! HTML::style('assets/global/plugins/uniform/css/uniform.default.min.css')!!}
{!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") !!}
{!! HTML::style("assets/global/plugins/datatables/plugins/responsive/responsive.bootstrap.css")!!}
{!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
{!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
{!! HTML::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css')!!}
        <!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')


        <!-- BEGIN PAGE HEADER-->
<div class="page-head"><div class="page-title"><h1>
            @lang("pages.billing.indexTitle")
        </h1></div></div>
<div class="page-bar">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span class="active">@lang("pages.billing.indexTitle")</span>
        </li>

    </ul>

</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        @if(!empty($setting->stripe_key) && !empty($setting->stripe_secret) && !empty($setting->stripe_webhook_secret))
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-key font-dark"></i> Current Plan
                    </div>
                    <div class="tools">
                        <div class="btn-group">
                            <a class="btn green" data-toggle="modal" onclick="loadView('{{route('admin.billing.change_plan')}}')">
                                {{ trans('core.changePlan') }}
                                <i class="fa fa-edit"></i> </a>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 text-right"><h4>Plan Name </h4></div>
                            <div class="col-md-6"><h4 class="text-success">{{ $loggedAdmin->company->subscriptionPlan->plan_name }}</h4></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6 text-right"><h4>Users </h4></div>
                            <div class="col-md-6"><h4 class="text-success">{{ $loggedAdmin->company->subscriptionPlan->start_user_count }} - {{ $loggedAdmin->company->subscriptionPlan->end_user_count }}</h4></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6 text-right"><h4>Monthly Price </h4></div>
                            <div class="col-md-6"><h4 class="text-success">{{ $loggedAdmin->company->subscriptionPlan->monthly_price }}</h4></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6 text-right"><h4>Annual Price </h4></div>
                            <div class="col-md-6"><h4 class="text-success">{{ $loggedAdmin->company->subscriptionPlan->annual_price }}</h4></div>
                        </div>
                    </div>

                </div>

            </div>
        @else
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="note note-danger"><i class="fa fa-close"></i> Administrator have not set stripe keys. Please contact to administrator.
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        @endif
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div id="load"></div>
        <div class="portlet light bordered">
            <div class="portlet-body">
                @can("create", new \App\Models\Invoice())
                <div class="table-toolbar">
                    <div class="row ">
                        <div class="col-md-12">
                            <button class="btn btn-primary" id="createInvoiceButton" onclick="createInvoice()" >
                                @lang("core.btnCreateInvoice")
                                <i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                </div>
                @endcan
                <table class="table table-striped table-bordered table-hover responsive" id="admins">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Number</th>
                        <th>Plan</th>
                        <th>Amount ($)</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($invoices as $key => $invoice)
                        @php
                            $date = \Carbon\Carbon::createFromTimeStamp($invoice->period_start)->toFormattedDateString();
                            $package = \App\Models\Plan::where(function ($query) use($invoice) {
            $query->where('stripe_annual_plan_id', '=', $invoice->lines->data[0]->plan->id)
                  ->orWhere('stripe_monthly_plan_id', '=', $invoice->lines->data[0]->plan->id);
        })->first();
                        @endphp
                        <tr>
                            <td> {{ $key+1 }} </td>
                            <td> {{ $invoice->number }} </td>
                            <td> {{ $package->plan_name }} </td>
                            <td> {{ round($invoice->total/100) }} </td>
                            <td> {{ $date }} </td>
                            <td> <a target="_blank" href="{{ $invoice->invoice_pdf }}" class="btn btn-primary btn-circle waves-effect" data-toggle="tooltip" data-original-title="Download"><span></span> <i class="fa fa-download"></i></a>  </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"> No invoice found </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->

    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Invoice</h4>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Invoice</h4>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
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
@if($loggedAdmin->company->country == "India")
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@else
    <script src="{{ env("2CHECKOUT_JS_URL") }}"></script>
    <form action='{{ env("2CHECKOUT_PAYMENT_URL") }}' method='post' id="checkoutForm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type='hidden' name='sid' value='{{ env("2CHECKOUT_SELLER_ID") }}' />
        <input type='hidden' name='mode' value='2CO' />
        <input type='hidden' name='li_0_type' value='product' />
        <input type='hidden' name='li_0_name' id='li_0_name' value='' />
        <input type='hidden' name='li_0_price' id='li_0_price' value='' />
        <input type='hidden' name='card_holder_name' value='' />
        <input type='hidden' name='street_address' value='' />
        <input type='hidden' name='street_address2' value='' />
        <input type='hidden' name='city' value='' />
        <input type='hidden' name='state' value='' />
        <input type='hidden' name='zip' value='' />
        <input type='hidden' name='country' value='{{ $loggedAdmin->company->country }}' />
        <input type='hidden' name='email' value='' />
        <input type='hidden' name='phone' value='' />
        <input type='hidden' name='phone' value='' />
        <input type='hidden' name='currency_code' id='currency' value='' />
        <input type='hidden' name='x_receipt_link_url' value='{{ route("admin.billing.pay2checkout") }}' />
        <input type='hidden' name='merchant_invoice_id' id="merchant_invoice_id" value='' />
        <input name='submit' type='submit' value='Checkout' class="hidden" id="checkoutButton"/>
    </form>
@endif
        <!-- END PAGE LEVEL PLUGINS -->

<script>

    @if ($payment == "success")
        showToastrMessage("@lang("messages.invoicePaymentSuccess")", "@lang("core.success")", "success");
    @elseif($payment == "fail")
        showToastrMessage("@lang("messages.invoicePaymentFail")", "@lang("core.error")", "error");
    @elseif($payment == "cancel")
        showToastrMessage("@lang("messages.invoicePaymentCancel")", "@lang("core.error")", "error");
    @endif

    $.fn.select2.defaults.set("theme", "bootstrap");

    $("#createModal").on('hidden.bs.modal', function () {
        $(this).find('.modal-body').html('Loading...');
        $(this).data('bs.modal', null);
    });

    function createInvoice() {
        var url = "{{ route("admin.billing.create") }}";

        $("#createModal").removeData('bs.modal').modal({
            remote: url,
            show: true
        });

        $("#createModal").on('loaded.bs.modal', function() {
            prepareModal();
        });

        $("#createModal").on('hidden.bs.modal', function () {
            $(this).find('.modal-body').html('Loading...');
            $(this).data('bs.modal', null);
        });
    }

    function showEdit(id) {
        var url = "{{ route("admin.billing.edit", ["id" => "#id"]) }}";
        url = url.replace("#id", id);

        $("#editModal").removeData('bs.modal').modal({
            remote: url,
            show: true
        });

        $("#editModal").on('loaded.bs.modal', function() {
            prepareModal();
        });

        $("#editModal").on('hidden.bs.modal', function () {
            $(this).find('.modal-body').html('Loading...');
            $(this).data('bs.modal', null);
        });
    }

    {{-- SignUp Code for other countries - PayPal --}}
    @if($loggedAdmin->company->country != "India")
        function pay2Checkout(id, planName, price, currency) {
            $("#li_0_name").val(planName);
            $("#li_0_price").val(price);
            $("#currency").val(currency);
            $("#merchant_invoice_id").val(id);
            $("#checkoutButton").click();
        }
    @else
       function payRazor(id, planName, planPrice) {
        var data = "invoice_id=" + id;

        var url = "{{ route("admin.billing.payRazor", "#id") }}";
        url = url.replace("#id", id);

        var options = {
            "key": "{{ env("RAZORPAY_CLIENT_ID") }}",
            "amount": planPrice,
            "name": "HRM",
            "description": planName,
            "image": "{{ asset("assets/admin/layout/img/longlogo.png") }}",
            "handler": function (response){
                $.ajax({
                    url: url,
                    data: data + "&payment_id=" + response.razorpay_payment_id,
                    beforeSend: function() {
                        blockUI("#admins");
                    },
                    success: function(response) {
                        unblockUI("#admins");

                        if (response.status == "success") {
                            showToastrMessage(response.message, "@lang("core.success")", "success");
                        }
                        else{
                            if (response.message != undefined) {
                                showToastrMessage(response.message, "@lang("core.error")", "error");
                            }
                            else {
                                showToastrMessage("@lang("messages.generalError")", "@lang("core.error")", "error");
                            }
                        }
                    },
                    error: function(){
                        unblockUI("#admins");
                        showToastrMessage("@lang("messages.generalError")", "@lang("core.error")", "error");
                    }
                })
            },
            "prefill": {
                "name": "{{ $loggedAdmin->company->company_name }}",
                "email": "{{ $loggedAdmin->company->email }}"
            },
            "notes": {
                "address": ""
            },
            "theme": {
                "color": "#F37254"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    }
    @endif
</script>
{{--INLCUDE ERROR MESSAGE BOX--}}

{{--END ERROR MESSAGE BOX--}}
@stop
