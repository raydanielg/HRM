<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\StripeInvoice;
use App\Traits\Settings;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Company;

class StripeWebhookController extends Controller
{
    use Settings;

    public function verifyStripeWebhook(Request $request)
    {
        $this->setStripeConfigs();
        Stripe::setApiKey(config('services.stripe.secret'));

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = config('services.stripe.webhook_secret');

        $payload = @file_get_contents("php://input");
        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid Payload', 400);
        } catch (\Stripe\Error\SignatureVerification $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        $payload = json_decode($request->getContent(), true);

        // Do something with $event
        if ($payload['type'] == 'invoice.payment_succeeded') {
            $customerId = $payload['data']['object']['customer'];

            $company = Company::where('stripe_id', $customerId)->first();

            if ($company) {

                // Change company status active after payment
                $company->license_expired = 0;
                $company->save();

                return response('Webhook Handled', 200);

            }

            return response('Customer not found', 200);
        } elseif ($payload['type'] == 'invoice.payment_failed') {
            $customerId = $payload['data']['object']['customer'];

            $company = Company::where('stripe_id', $customerId)->first();

            if ($company) {
                // Change company status license expired after payment failed
                $company->license_expired = 1;
                $company->save();

                return response('Company status changed to license expired', 200);
            }

            return response('Customer not found', 200);
        }

    }

    public function saveInvoices(Request $request) {

        $this->setStripeConfigs();

        $stripeCredentials = config('services.stripe.webhook_secret');

        Stripe::setApiKey(config('services.stripe.secret'));

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $stripeCredentials;

        $payload = @file_get_contents("php://input");
        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid Payload', 400);
        } catch(\Stripe\Error\SignatureVerification $e) {
            // Invalid signature
            return response('Invalid signature', 400);
        }

        $payload = json_decode($request->getContent(), true);

        // Do something with $event
        if ($payload['type'] == 'invoice.payment_succeeded')
        {
            $planId = $payload['data']['object']['lines']['data'][0]['plan']['id'];
            $customerId = $payload['data']['object']['customer'];
            $amount = $payload['data']['object']['amount_paid'];
            $transactionId = $payload['data']['object']['lines']['data'][0]['id'];
            $invoiceId = $payload['data']['object']['number'];

            $company = Company::where('stripe_id', $customerId)->first();

            $package = Plan::where(function ($query) use($planId) {
                $query->where('stripe_annual_plan_id', '=', $planId)
                    ->orWhere('stripe_monthly_plan_id', '=', $planId);
            })->first();

            if($company) {
                // Store invoice details
                $stripeInvoice = new StripeInvoice();
                $stripeInvoice->company_id = $company->id;
                $stripeInvoice->invoice_id = $invoiceId;
                $stripeInvoice->transaction_id = $transactionId;
                $stripeInvoice->amount = $amount/100;
                $stripeInvoice->subscription_plan_id = $package->id;
                $stripeInvoice->pay_date = \Carbon\Carbon::createFromTimeStamp($payload['data']['object']['date'])->format('Y-m-d')
                ;
                $stripeInvoice->next_pay_date = \Carbon\Carbon::createFromTimeStamp($company->upcomingInvoice()->next_payment_attempt)-> format('Y-m-d');

                $stripeInvoice->save();

                // Change company status active after payment

                $company->status = 'active';
                $company->save();

                return response('Webhook Handled', 200);

            }

            return response('Customer not found', 200);
        }

        elseif ($payload['type'] == 'invoice.payment_failed') {
            $customerId = $payload['data']['object']['customer'];

            $company = Company::where('stripe_id', $customerId)->first();

            if($company) {
                // Change company status license expired after payment failed
                $company->status = 'license_expired';
                $company->save();

                return response('Company status changed to license expired', 200);
            }

            return response('Customer not found', 200);
        }
    }
}
