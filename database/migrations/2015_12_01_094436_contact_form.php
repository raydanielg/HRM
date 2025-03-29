<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("contact_requests", function(Blueprint $table) {
            $table->increments("id");
            $table->string("name", 70);
            $table->string("email", 255);
            $table->string("category", 50);
            $table->string("details", 1000);
            $table->enum("status", ["Pending", "Completed"]);
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
        Schema::dropIfExists("contact_requests");
    }
}
