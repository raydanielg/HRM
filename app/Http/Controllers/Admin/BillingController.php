<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\Admin;
use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Plan;
use App\Models\Setting;
use App\Traits\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Billing\StoreRequest;
use App\Http\Requests\Admin\Billing\UpdateRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Razorpay\Api\Api;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Billing\PaymentRequest;

class BillingController extends AdminBaseController
{

    use \App\Traits\Settings;
    public $currencySymbols = [
        "USD" => "$",
        "GBP" => "£",
        "EUR" => "€",
        "INR" => "₹"
    ];

    public function __construct()
    {
        parent::__construct();
        $this->setStripeConfigs();

        $this->pageTitle = "Billing";
        $this->csettingOpen = 'active';
        $this->billingActive = 'active';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->invoices = (admin()->company->subscriptions->count() > 0) ? admin()->company->invoices() : [];
        $this->data["payment"] = \Input::get("payment");

        return \View::make('admin.billing.index', $this->data);
    }

    // Datatable ajax request
    public function ajax_billing()
    {
        if (admin()->type == "admin") {
            $result = Invoice::leftJoin("companies", "companies.id", "=", "invoices.company_id")
                ->select("invoices.id", "companies.company_name", "invoices.license_number", "invoices.invoice_number",
                    "invoices.invoice_date", "invoices.due_date", "invoices.amount", "invoices.currencySymbol", "invoices.currency",
                    "invoices.status", "invoices.transaction_id")
                ->where("company_id", $this->data["active_company"]->id)
                ->get();
        } else {
            $result = Invoice::leftJoin("companies", "companies.id", "=", "invoices.company_id")
                ->select("invoices.id", "companies.company_name", "invoices.license_number", "invoices.invoice_number",
                    "invoices.invoice_date", "invoices.due_date", "invoices.amount", "invoices.currencySymbol",
                    "invoices.status", "invoices.transaction_id")
                ->get();
        }

        return DataTables::of($result)->editColumn('invoice_date', function ($row) {
            if (Carbon::now()->isSameDay($row->invoice_date)) {
                return $row->invoice_date->format("d-M-y") . "<br/>(Today)";
            } else {
                return $row->invoice_date->format("d-M-y") . "<br/>(" . $row->invoice_date->diffForHumans() . ")";
            }

        })->editColumn('due_date', function ($row) {
            if (Carbon::now()->isSameDay($row->due_date)) {
                return $row->due_date->format("d-M-y") . "<br/>(Today)";
            } else {
                return $row->due_date->format("d-M-y") . "<br/>(" . $row->due_date->diffForHumans() . ")";
            }
        })->editColumn('amount', function ($row) {
            return $row->currencySymbol . number_format($row->amount, 2);
        })->editColumn('status', function ($row) {
            if ($row->status == "Paid") {
                return '<span class="label label-success">' . $row->status . "</span>";
            } else if ($row->status == "Unpaid") {
                return '<span class="label label-danger">' . $row->status . "</span>";
            } else if ($row->status == "Cancelled") {
                return '<span class="label label-default">' . $row->status . "</span>";
            } else {
                return '<span class="label label-warning">' . $row->status . "</span>";
            }

        })->addColumn('edit', function ($row) {

            $string = "";
            if (admin()->type == "admin" && $row->status == "Unpaid") {
                if ($this->data["active_company"]->country == "India") {
                    $string .= '<a class="btn purple btn-sm margin-bottom-10"  href="javascript:;" onclick="payRazor(' . $row->id . ', \'HRM Cloud\', ' . ($row->amount * 100) . ');return false;" >
                                                      <i class="fa fa-money"></i> Pay</a>';
                } else {
                    $string .= '<a class="btn purple btn-sm margin-bottom-10"  href="javascript:;" onclick="pay2Checkout(\'' . $row->id . '\', \'HRM Cloud\', ' . ($row->amount) . ', \'' . $row->currency . '\');return false;" >
                                                      <i class="fa fa-money"></i> Pay</a>';
                }
            } else if (admin()->type == "superadmin") {
                $string .= '<a class="btn green btn-sm margin-bottom-10"  href="javascript:;" onclick="showEdit(' . $row->id . ');return false;" >
                                                      <i class="fa fa-edit"></i> Edit</a>';
            }


            $string .= '<a class="btn blue btn-sm margin-bottom-10"  href="' . route("admin.billing.show", ["id" => $row->id]) . '" >
										          <i class="fa fa-download"></i> PDF</a>';

            return $string;
        })->removeColumn("id")
            ->removeColumn("currencySymbol")
            ->removeColumn("currency")
            ->rawColumns(['invoice_date', 'due_date', 'amount', 'status', 'edit'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize(new Invoice());

        $id = Invoice::max("id");

        $this->data["invoice_number"] = "SNAP" . ($id + 1);
        return view("admin.billing.create", $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize(new Invoice());

        $data = \Input::all();

        $invoice = new Invoice();
        $invoice->invoice_number = $data["invoice_number"];
        $invoice->company_id = $data["company_id"];
        $invoice->license_number = $data["license_number"];
        $invoice->amount = $data["amount"];
        $invoice->invoice_date = $data["invoice_date"];
        $invoice->due_date = $data["due_date"];
        $invoice->status = $data["status"];
        $invoice->notes = $data["notes"];
        $invoice->currency = $data["currency"];
        $invoice->currencySymbol = $this->currencySymbols[$data["currency"]];
        $invoice->transaction_id = ($data["transaction_id"] == "") ? null : $data["transaction_id"];
        $invoice->save();

        for ($i = 0; $i < count($data["item_name"]); $i++) {
            $item = new InvoiceItem();
            $item->invoice_id = $invoice->id;
            $item->name = $data["item_name"][$i];
            $item->type = $data["item_type"][$i];
            $item->amount = $data["item_amount"][$i];
            $item->save();
        }

        if (isset($data["send_email"]) && $data["send_email"] == "on") {
            $admins = Admin::company($invoice->company_id)
                ->where("manager", "0")->pluck("email");

            foreach ($admins as $admin) {

                $active_company = Company::find($invoice->company_id);

                $emailInfo = ['from_email' => $this->setting->email,
                    'from_name' => $this->setting->name,
                    'to' => $admin,
                    'active_company' => $active_company];

                $amount = ($invoice->currencySymbol) . number_format($invoice->amount, 2);
                $date_generated = $invoice->invoice_date->format("dS M Y");
                if (Carbon::now()->isSameDay($invoice->invoice_date)) {
                    $date_generated .= "(Today)";
                } else {
                    $date_generated .= "(" . $invoice->invoice_date->diffForHumans() . ")";
                }

                $due_date = $invoice->due_date->format("dS M Y");
                if (Carbon::now()->isSameDay($invoice->due_date)) {
                    $due_date .= "(Today)";
                } else {
                    $due_date .= "(" . $invoice->due_date->diffForHumans() . ")";
                }

                $fieldValues = ['PRODUCT' => "HRM Cloud",
                    'AMOUNT' => $amount,
                    'DATE_GENERATED' => $date_generated,
                    'DUE_DATE' => $due_date,
                    'INVOICE_NUMBER' => $invoice->invoice_number];

                EmailTemplate::prepareAndSendEmail('NEW_INVOICE_GENERATED', $emailInfo, $fieldValues);
            }
        }

        return [
            "status" => "success",
            "message" => trans("messages.invoiceAddSuccess")
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);

        $this->authorize($invoice);

//            return view("admin.billing.show", ["invoice" => $invoice]);

        return \PDF::loadView("admin.billing.show", ["invoice" => $invoice])
            ->download($invoice->invoice_number . ".pdf");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);

        $this->authorize($invoice);

        $this->data["invoice"] = $invoice;

        return view("admin.billing.edit", $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $invoice = Invoice::find($id);

        $this->authorize($invoice);

        $data = \Input::all();


        $invoice->invoice_number = $data["invoice_number"];
        $invoice->company_id = $data["company_id"];
        $invoice->license_number = $data["license_number"];
        $invoice->amount = $data["amount"];
        $invoice->invoice_date = $data["invoice_date"];
        $invoice->due_date = $data["due_date"];
        $invoice->status = $data["status"];
        $invoice->notes = $data["notes"];
        $invoice->currency = $data["currency"];
        $invoice->currencySymbol = $this->currencySymbols[$data["currency"]];
        $invoice->transaction_id = ($data["transaction_id"] == "") ? null : $data["transaction_id"];
        $invoice->save();

        InvoiceItem::where("invoice_id", $invoice->id)->delete();

        for ($i = 0; $i < count($data["item_name"]); $i++) {
            $item = new InvoiceItem();
            $item->invoice_id = $invoice->id;
            $item->name = $data["item_name"][$i];
            $item->type = $data["item_type"][$i];
            $item->amount = $data["item_amount"][$i];
            $item->save();
        }

        if (isset($data["send_email"]) && $data["send_email"] == "on") {
            $admins = Admin::company($invoice->company_id)
                ->where("manager", "0")->pluck("email");

            foreach ($admins as $admin) {
                $active_company = Company::find($invoice->company_id);

                $emailInfo = ['from_email' => $this->setting->email,
                    'from_name' => $this->setting->name,
                    'to' => $admin,
                    'active_company' => $active_company];

                $amount = ($invoice->currencySymbol) . number_format($invoice->amount, 2);
                $date_generated = $invoice->invoice_date->format("dS M Y");
                if (Carbon::now()->isSameDay($invoice->invoice_date)) {
                    $date_generated .= "(Today)";
                } else {
                    $date_generated .= "(" . $invoice->invoice_date->diffForHumans() . ")";
                }

                $due_date = $invoice->due_date->format("dS M Y");
                if (Carbon::now()->isSameDay($invoice->due_date)) {
                    $due_date .= "(Today)";
                } else {
                    $due_date .= "(" . $invoice->due_date->diffForHumans() . ")";
                }

                $fieldValues = ['PRODUCT' => "HRM Cloud",
                    'AMOUNT' => $amount,
                    'DATE_GENERATED' => $date_generated,
                    'DUE_DATE' => $due_date,
                    'INVOICE_NUMBER' => $invoice->invoice_number
                ];

                EmailTemplate::prepareAndSendEmail('NEW_INVOICE_GENERATED', $emailInfo, $fieldValues);
            }
        }

        return [
            "status" => "success",
            "message" => trans("messages.invoiceUpdateSuccess")
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax_company_name()
    {
        $q = \Input::get("q");

        $result = Company::join("licenses", "licenses.company_id", "=", "companies.id")
            ->select("id", "company_name as text", "license_number")
            ->where("company_name", "LIKE", "%" . $q . "%")
            ->get();

        return ["items" => $result];
    }

    public function pay($id)
    {
        $invoice = Invoice::find($id);

        $this->authorize($invoice);

        $apiContext = new ApiContext(new OAuthTokenCredential(env("PAYPAL_CLIENT_ID"), env("PAYPAL_SECRET")));

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName("HRM Cloud");
        $item1->setCurrency($invoice->currency);
        $item1->setQuantity(1);
        $item1->setPrice($invoice->amount);

        $itemList = new ItemList();
        $itemList->setItems([$item1]);

        $amount = new Amount();
        $amount->setCurrency($invoice->currency);
        $amount->setTotal($invoice->amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setItemList($itemList);
        $transaction->setDescription("HRM Cloud license payment");

        $returnUrlLink = \URL::route('admin.billing.payment.success') . "?item_id=" . $invoice->id;
        $cancelUrlLink = \URL::route('admin.billing.payment.cancel') . "?item_id=" . $invoice->id;

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($returnUrlLink);
        $redirectUrls->setCancelUrl($cancelUrlLink);

        $payment = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions([$transaction]);

        try {
            $payment->create($apiContext);
        } catch (PayPalConnectionException $ex) {
            $errorDetails = json_decode($ex->getData(), true);

            $errorData = ["status" => "fail",
                "message" => (!isset($errorDetails["message"]) || $errorDetails["message"] == null) ? "Connection problem. Please try again later" : $errorDetails["message"],
                "detail" => (!isset($errorDetails["message"]) || $errorDetails["message"] == null) ? "Connection problem. Please try again later" : $errorDetails["name"],
                "debug_id" => (!isset($errorDetails["message"]) || $errorDetails["message"] == null) ? "Connection problem. Please try again later" : $errorDetails["debug_id"]];

            return $errorData;
        }

        $approvalUrl = $payment->getApprovalLink();
        $payment_id = $payment->getId();

        // Save this transaction

        $saveTransaction = new \App\Models\Transaction();
        $saveTransaction->payment_id = $payment_id;
        $saveTransaction->payment_status = "pending";
        $saveTransaction->user_details = json_encode([]);
        $saveTransaction->save();

        return ["status" => "success",
            "message" => "Redirecting to payment page...",
            "action" => "redirect", "url" => $approvalUrl];
    }

    public function payRazor($id)
    {

        $invoice = Invoice::find($id);

        $this->authorize($invoice);

        $inputs = \Input::all();

        // Currency Convert
        try {

            $price = $invoice->amount;
            $api = new Api(env("RAZORPAY_CLIENT_ID"), env("RAZORPAY_SECRET"));
            $payment = $api->payment->fetch($inputs["payment_id"]);
            $payment->capture(['amount' => $price * 100]);

        } catch (\Exception $e) {
            $errorData = ["status" => "fail",
                "message" => $e->getMessage()
            ];

            return $errorData;
        }

        $invoice->status = "Paid";
        $invoice->save();

        // Save this transaction

        $saveTransaction = new \App\Models\Transaction();
        $saveTransaction->payment_id = $payment->id;
        $saveTransaction->user_details = json_encode($inputs);
        $saveTransaction->payer_id = "";
        $saveTransaction->transaction_id = "";
        $saveTransaction->payer_email = $payment->email;
        $saveTransaction->payment_method = "Razorpay";
        $saveTransaction->payer_fname = $invoice->company->company_name;
        $saveTransaction->payer_lname = "";
        $saveTransaction->amount = $payment->amount / 100;
        $saveTransaction->currency_code = "INR";
        $saveTransaction->license_number = $invoice->license_number;
        $saveTransaction->create_time = Carbon::createFromTimestamp($payment->created_at);
        $saveTransaction->update_time = new \DateTime();
        $saveTransaction->payment_status = $payment->status;
        $saveTransaction->user_details = json_encode($inputs);

        $saveTransaction->save();

        $admins = Admin::company($invoice->company_id)
            ->where("manager", "0")->pluck("email");

        $active_company = Company::find($invoice->company_id);
        $active_company->license_expired = false;
        $active_company->save();

        foreach ($admins as $admin) {

            $active_company = Company::find($invoice->company_id);

            $emailInfo = ['from_email' => $this->setting->email,
                'from_name' => $this->setting->name,
                'to' => $admin,
                'active_company' => $active_company];

            $amount = ($invoice->currencySymbol) . number_format($invoice->amount, 2);

            $fieldValues = ['INVOICE_NUMBER' => $invoice->invoice_number,
                'AMOUNT' => $amount,
                'TRANSACTION_ID' => $saveTransaction->payment_id];

            EmailTemplate::prepareAndSendEmail('PAYMENT_SUCCESS', $emailInfo, $fieldValues);
        }


        return ["status" => "success",
            "message" => trans("messages.invoicePaymentSuccess")];


    }

    public function pay2Checkout()
    {
        $order_number = \Input::get("order_number");
        $amount = \Input::get("total");
        $key = \Input::get("key");
        $invoice_id = \Input::get("merchant_invoice_id");

        // First verify genuine response
        $calculated_key = strtoupper(md5(env("2CHECKOUT_SECRET_WORD") . env("2CHECKOUT_SELLER_ID") . $order_number . $amount));

        if ($key != $calculated_key) {
            \App::abort(403, "This is not an authorised request");
        }

        $invoice = Invoice::find($invoice_id);

        if (!$invoice) {
            \App::abort(500, "Invoice not found");
        }

        $invoice->status = "Paid";
        $invoice->save();

        $saveTransaction = new \App\Models\Transaction();
        $saveTransaction->payment_id = $order_number;
        $saveTransaction->payer_id = "";
        $saveTransaction->transaction_id = \Input::get("invoice_id");
        $saveTransaction->payer_email = \Input::get("email");
        $saveTransaction->payment_method = "2Checkout";
        $saveTransaction->payer_fname = \Input::get("first_name");
        $saveTransaction->payer_lname =
        $saveTransaction->amount = $amount;
        $saveTransaction->currency_code = \Input::get("currency_code");
        $saveTransaction->license_number = $invoice->license_number;
        $saveTransaction->create_time = Carbon::now();
        $saveTransaction->update_time = new \DateTime();
        $saveTransaction->payment_status = "success";
        $saveTransaction->user_details = json_encode(\Input::all());

        $saveTransaction->save();

        $admins = Admin::company($invoice->company_id)
            ->where("manager", "0")->pluck("email");

        $active_company = Company::find($invoice->company_id);
        $active_company->license_expired = false;
        $active_company->save();

        foreach ($admins as $admin) {

            $active_company = Company::find($invoice->company_id);

            $emailInfo = ['from_email' => $this->setting->email,
                'from_name' => $this->setting->name,
                'to' => $admin,
                'active_company' => $active_company];

            $amount = ($invoice->currencySymbol) . number_format($invoice->amount, 2);

            $fieldValues = ['INVOICE_NUMBER' => $invoice->invoice_number,
                'AMOUNT' => $amount,
                'TRANSACTION_ID' => $saveTransaction->payment_id];

            EmailTemplate::prepareAndSendEmail('PAYMENT_SUCCESS', $emailInfo, $fieldValues);
        }

        return \Redirect::to(route("admin.billing.index") . "?payment=success");
    }

    public function paymentSuccess()
    {
        $itemID = \Input::get('item_id');
        $paymentId = \Input::get('paymentId');
        $payerID = \Input::get('PayerID');

        $invoice = Invoice::find($itemID);

        $apiContext = new ApiContext(new OAuthTokenCredential(env("PAYPAL_CLIENT_ID"), env("PAYPAL_SECRET")));

        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);

        try {
            $payment = Payment::get($paymentId, $apiContext);
            $payment->execute($execution, $apiContext);
        } catch (PayPalConnectionException $ex) {
            $errorDetails = json_decode($ex->getData(), true);

            $errorData = ["status" => "fail", "message" => $errorDetails["message"],
                "detail" => $errorDetails["name"], "debug_id" => $errorDetails["debug_id"]];

            $txn = \App\Models\Transaction::where("payment_id", $paymentId)->first();

            if ($txn && $txn->payment_status != "approved") {
                $txn->payment_status = "failed";
                $txn->payer_id = $payerID;
                $txn->failure_data = $ex->getData();
                $txn->save();
            }

            return \Redirect::to(route("admin.billing.index") . "?payment=fail");
        }

        $payment_id = $payment->id;
        $payment_create = $payment->create_time;
        $payment_update = $payment->update_time;

        $payment_status = $payment->state;
        $payment_method = $payment->payer->payment_method;
        $payer_email = $payment->payer->payer_info->email;
        $payer_fname = $payment->payer->payer_info->first_name;
        $payer_lname = $payment->payer->payer_info->last_name;
        $payer_id = $payment->payer->payer_info->payer_id;
        $trans_id = "";
        $total_amount = 0.0;
        $currency_code = "USD";

        foreach ($payment->transactions as $trans) {
            $total_amount = $trans->amount->total;
            $currency_code = $trans->amount->currency;

            foreach ($trans->related_resources as $resources) {
                $trans_id = $resources->sale->id;
            }
        }

        if ($payment) {
            $invoice->status = "Paid";
            $invoice->save();

            $data = ['payer_id' => $payer_id, 'transaction_id' => $trans_id, 'payer_email' => $payer_email,
                'payment_method' => $payment_method, 'payer_fname' => $payer_fname,
                'payer_lname' => $payer_lname, 'amount' => $total_amount, 'currency_code' => $currency_code,
                'create_time' => $payment_create, 'update_time' => $payment_update,
                'license_number' => $invoice->license_number,
                'payment_status' => $payment_status];

            $userTransaction = \App\Models\Transaction::where("payment_id", $payment_id)->first();

            $userTransaction->update($data);

            $inputs = json_decode($userTransaction->user_details, true);

            $admins = Admin::company($invoice->company_id)
                ->where("manager", "0")->pluck("email");

            $active_company = Company::find($invoice->company_id);
            $active_company->license_expired = false;
            $active_company->save();

            foreach ($admins as $admin) {

                $emailInfo = ['from_email' => $this->setting->email,
                    'from_name' => $this->setting->name,
                    'to' => $admin,
                    'active_company' => $active_company];

                $amount = ($invoice->currencySymbol) . number_format($invoice->amount, 2);

                $fieldValues = ['INVOICE_NUMBER' => $invoice->invoice_number,
                    'AMOUNT' => $amount,
                    'TRANSACTION_ID' => $userTransaction->payment_id];

                EmailTemplate::prepareAndSendEmail('PAYMENT_SUCCESS', $emailInfo, $fieldValues);
            }

            return \Redirect::to(route("admin.billing.index") . "?payment=success");
        } else {
            return \Redirect::to(route("admin.billing.index") . "?payment=fail");
        }
    }

    public function paymentCancel()
    {
        $paymentId = \Input::get('paymentId');
        $payerID = \Input::get('PayerID');

        $txn = \App\Models\Transaction::where("payment_id", $paymentId)->first();

        if ($txn && $txn->payment_status != "approved") {
            $txn->payment_status = "failed";
            $txn->payer_id = $payerID;
            $txn->failure_data = "Payment Cancel";
            $txn->save();
        }

        return \Redirect::to(route("admin.billing.index") . "?payment=cancel");
    }

    public function changePlan()
    {
        $this->plans = Plan::all();

        return view("admin.billing.change_plan", $this->data);
    }

    public function stripePayment(PaymentRequest $request)
    {
        $token = $request->stripeToken;
        $email = $request->stripeEmail;
        $plan = Plan::find($request->plan_id);

        $this->setStripeConfigs();

        if($plan->end_user_count < admin()->company->users->count() ) {
            return back()->withError('You can\'t downgrade package because your users length is '.admin()->company->users->count().' and package max users length is '.$plan->end_user_count)->withInput();
        }

        $company = admin()->company;
        $subscription = $company->subscriptions;

        try {
            if ($subscription->count() > 0) {
                $company->subscription('main')->swap($plan->{'stripe_' . $request->type . '_plan_id'});
            }
            else {
                $company->newSubscription('main', $plan->{'stripe_'.$request->type.'_plan_id'})->create($token, [
                    'email' => $email,
                ]);
            }

            $company = Company::find(admin()->company->id);

            $company->subscription_plan_id = $plan->id;
            $company->package_type = $request->type;

            // Set company status active
            $company->status = 'active';


            $company->save();

            \Session::flash('message', 'Payment successfully done.');
            return redirect(route('admin.billing.index'));

        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
