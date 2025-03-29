<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceEmailsTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        $email = new \App\Models\EmailTemplate();
        $email->email_id = 'INVOICE_ONE_DAY_LEFT_NOTICE';
        $email->subject = '1 Day left for License Expired';
        $email->body = 'Hi,<br/>
                            <br/>
                            
                            Only 1 day is left for your license to get expired.
                            Pay the invoice to continue using our services.<br/>
                            <br/>
                            An invoice is pending in your on HRM account. Details are as follows:<br/>
                            <b>Product:</b> ##PRODUCT##<br/>
                            <b>Invoice Number:</b> ##INVOICE_NUMBER##<br/>
                            <b>Amount:</b> ##AMOUNT##<br/>
                            <b>Date Generated:</b> ##DATE_GENERATED##<br/>
                            <b>Due Date:</b> ##DUE_DATE##<br/>
                            <br/>
                            <br/>';
        $email->save();


        $email = new \App\Models\EmailTemplate();
        $email->email_id = 'LICENSE_EXPIRED';
        $email->subject = 'License Expired';
        $email->body = 'Hi,<br/>
                            <br/>
                            Your HRM license is expired due to non-payment of invoice. To pay now go to you account and pay. Details are as follows:<br/>
                            <br/>
                            <b>Product:</b> ##PRODUCT##<br/>
                            <b>Invoice Number:</b> ##INVOICE_NUMBER##<br/>
                            <b>Amount:</b> ##AMOUNT##<br/>
                            <b>Date Generated:</b> ##DATE_GENERATED##<br/>
                            <b>Due Date:</b> ##DUE_DATE##<br/>
                            <br/>
                            <br/><br/>';
        $email->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
