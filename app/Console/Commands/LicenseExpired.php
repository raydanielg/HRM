<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Company;
use App\Models\EmailTemplate;
use App\Models\Invoice;
use App\Models\Setting;

use Illuminate\Console\Command;

class LicenseExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:license-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $invoices = Invoice::where('due_date','<',date("Y-m-d"))->where('status','Unpaid')->get();

        $setting = Setting::first();
        foreach ($invoices as $invoice) {
            $company = Company::where('id',$invoice->company_id)
                ->where('license_expired',0)->first();
            if($company)
            {
                //region Send Email
                $company->update(["license_expired" => 1]);

                $admins = Admin::company($invoice->company_id)
                    ->where("manager", "0")->lists("email");
                foreach ($admins as $admin) {

                    $active_company = Company::find($invoice->company_id);

                    $emailInfo = [
                        'from_email' => $setting->email,
                        'from_name' => $setting->name,
                        'to' => $admin,
                        'active_company' => $active_company
                    ];

                    $amount = ($invoice->currencySymbol) . number_format($invoice->amount, 2);
                    $date_generated = $invoice->invoice_date->format("dS M Y");

                    $due_date = $invoice->due_date->format("dS M Y");

                    $fieldValues = [
                        'PRODUCT' => $setting->main_name,
                        'AMOUNT' => $amount,
                        'DATE_GENERATED' => $date_generated,
                        'DUE_DATE' => $due_date,
                        'INVOICE_NUMBER' => $invoice->invoice_number
                    ];
                    EmailTemplate::prepareAndSendEmail('LICENSE_EXPIRED', $emailInfo, $fieldValues);
                }
                //endregion
            }
        }
        \DB::commit();
        $this->info('Invoice notice emailed successfully!');


    }
}
