<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\InvoiceItem;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class CreateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:invoice-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Invoice On First Day Of Month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \DB::beginTransaction();

        $licenseType = LicenseType::where('type','Cloud')->first();

        $companies = Company::where('license_expired',0)
            ->whereRaw('(Select Count(*) from employees where employees.company_id = companies.id) > '.$licenseType->free_users)
            ->get();

        foreach ($companies as $company) {
            $licenses = License::where('company_id', $company->id)->first();
            if($licenses->license_type_id == $licenseType->id) {
                $id = Invoice::max("id");
                $invoice_number = "SNAP" . ($id + 1);

                //region Save Invoice
                $invoice = new Invoice();
                $invoice->invoice_number = $invoice_number;
                $invoice->company_id = $company->id;
                $invoice->license_number = $licenses->license_number;
                $invoice->invoice_date = date("Y-m-d");
                $invoice->due_date = date("Y-m-d", strtotime("+7 days"));
                $invoice->status = "Unpaid";

                if ($company->currency == "INR") {

                    $invoice->amount = DB::table('license_country_pricing')->where("license_type_id", $licenses->license_type_id)->first()->price;

                    $invoice->currency = $company->currency;
                    $invoice->currencySymbol = "₹";

                } else {

                    $invoice->amount = $licenseType->price;
                    $invoice->currency = "USD";
                    $invoice->currencySymbol = "$";
                }

                $invoice->transaction_id = null;
                $invoice->save();
                //endregion

                //region Invoice Item
                $item = new InvoiceItem();
                $item->invoice_id = $invoice->id;
                $item->name = date('F') . " Month Bill";
                $item->type = "Item";
                $item->amount = $invoice->amount;
                $item->save();
                //endregion

                //region Send Email
                $setting = Setting::first();
                $admins = Admin::company($invoice->company_id)
                    ->where("manager", "0")->lists("email");
                foreach ($admins as $admin) {

                    $active_company = Company::find($invoice->company_id);

                    $emailInfo = ['from_email' => $setting->email,
                        'from_name' => $setting->name,
                        'to' => $admin,
                        'active_company' => $active_company];

                    $amount = ($invoice->currencySymbol) . number_format($invoice->amount, 2);
                    $date_generated = $invoice->invoice_date->format("dS M Y");
                    $date_generated .= "(Today)";

                    $due_date = $invoice->due_date->format("dS M Y");
                    $due_date .= "(" . $invoice->due_date->diffForHumans() . ")";

                    $fieldValues = ['PRODUCT' => "HRM Cloud",
                        'AMOUNT' => $amount,
                        'DATE_GENERATED' => $date_generated,
                        'DUE_DATE' => $due_date,
                        'INVOICE_NUMBER' => $invoice->invoice_number];
                    EmailTemplate::prepareAndSendEmail('NEW_INVOICE_GENERATED', $emailInfo, $fieldValues);
                }
            }
            //endregion
        }
        \DB::commit();
        $this->info('Invoice emailed successfully!');

    }
}
