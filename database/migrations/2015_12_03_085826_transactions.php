<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("transactions", function(Blueprint $table) {
            $table->increments("id");
            $table->string("payment_id", 50);
            $table->string("payer_id", 50);
            $table->string("transaction_id", 50);
            $table->string("payer_email", 255);
            $table->string("payment_method", 50);
            $table->string("payer_fname", 30);
            $table->string("payer_lname", 30);
            $table->decimal("amount", 10, 2);
            $table->string("currency_code", 10);
            $table->string("payment_status", 10);
            $table->dateTime("create_time");
            $table->dateTime("update_time");
            $table->string("user_details", 3000);
            $table->string("failure_data", 3000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("transactions");
    }
}
