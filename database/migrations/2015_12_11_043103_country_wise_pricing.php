<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CountryWisePricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("license_country_pricing", function(Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("license_type_id");
            $table->foreign("license_type_id")->references("id")->on("license_types")->onUpdate("cascade")->onDelete("cascade");
            $table->string("country", 100);
            $table->string("currency_code", 5);
            $table->string("currency_symbol", 5);
            $table->decimal("price", 8, 2);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("license_country_pricing");
    }
}
