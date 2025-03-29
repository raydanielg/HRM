<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    protected $table = "invoices";
    use SoftDeletes;

    public function items()
    {
        return $this->hasMany("App\\Models\\InvoiceItem", "invoice_id", "id");
    }

    public function company()
    {
        return $this->belongsTo("App\\Models\\Company", "company_id", "id");
    }

    public function setInvoiceDateAttribute($value)
    {
        $this->attributes["invoice_date"] = Carbon::parse($value)->format("Y-m-d");
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes["due_date"] = Carbon::parse($value)->format("Y-m-d");
    }

    public function getInvoiceDateAttribute($value)
    {
        return Carbon::createFromFormat("Y-m-d", $value);
    }

    public function getDueDateAttribute($value)
    {
        return Carbon::createFromFormat("Y-m-d", $value);
    }
}
