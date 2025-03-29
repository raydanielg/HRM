<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table = "invoice_items";
    public $timestamps = false;

    public function invoice() {
        return $this->belongsTo("App\\Models\\Invoice", "invoice_id", "id");
    }
}
