<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeInvoice extends Model
{
    protected $table = 'stripe_invoices';
    protected $dates = ['pay_date', 'next_pay_date'];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id')->withoutGlobalScopes(['active']);
    }

    public function plan() {
        return $this->belongsTo(Plan::class, 'subscription_plan_id');
    }
}
