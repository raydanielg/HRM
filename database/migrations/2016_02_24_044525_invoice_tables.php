<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoiceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("invoices", function(Blueprint $table) {
           $table->increments("id");
            $table->char("license_number", 36)->nullable();
            $table->foreign("license_number")->references("license_number")->on("licenses")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedInteger("company_id")->nullable();
            $table->foreign("company_id")->references("id")->on("companies")->onUpdate("cascade")->onDelete("cascade");
            $table->string("invoice_number", 10);
            $table->decimal("amount", 13, 2);
            $table->char("currency", 3)->default("USD");
            $table->char("currencySymbol", 3)->default("$");
            $table->date("invoice_date")->nullable();
            $table->date("due_date")->nullable();
            $table->enum("status", ["Paid", "Unpaid", "Cancelled", "Error"])->default("Unpaid");
            $table->text("notes");
            $table->unsignedInteger("transaction_id")->nullable();
            $table->foreign("transaction_id")->references("id")->on("transactions")->onUpdate("cascade")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("invoice_items", function(Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("invoice_id");
            $table->foreign("invoice_id")->references("id")->on("invoices")->onUpdate("cascade")->onDelete("cascade");
            $table->string("name", 255);
            $table->enum("type", ["Item", "Tax", "Discount"]);
            $table->decimal("amount", 13, 2);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("invoice_items");
        Schema::dropIfExists("invoices");
    }
}
