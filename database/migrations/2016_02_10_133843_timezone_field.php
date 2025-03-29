<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimezoneField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("companies", function(Blueprint $table) {
           $table->string("timezone", 10)->after("currency_symbol")->default("+00:00=29");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("companies", function(Blueprint $table) {
           $table->dropColumn("timezone");
        });
    }
}
