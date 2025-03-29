<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Licenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("licenses", function(Blueprint $table) {
            $table->char("license_number", 36)->primary();
            $table->string("name", 70);
            $table->string("email", 255);
            $table->string("company", 100);
            $table->string("subdomain", 100);
            $table->unsignedInteger("license_type_id");
            $table->foreign("license_type_id")->references("id")->on("license_types");
            $table->enum("status", ["Valid", "Expired", "Disabled"])->default("Valid");
            $table->date("expires_on");
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
        Schema::dropIfExists("licenses");
    }
}
