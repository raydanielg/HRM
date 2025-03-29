<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{


    protected $table = "transactions";

    protected $guarded = ["id"];

    public static function convertAmount($amount, $fromCurrency)
    {
        $currencyConversion = file_get_contents("currency.json");;

        $jsonData = json_decode($currencyConversion);

        $value = round(($amount / ($jsonData->rates->$fromCurrency)), 0);

        return $value;
    }
}
