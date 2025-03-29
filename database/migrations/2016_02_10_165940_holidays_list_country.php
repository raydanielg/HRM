<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HolidaysListCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("holidays_list", function(Blueprint $table) {
            $table->increments("id");
            $table->date("date");
            $table->string("name", 50);
            $table->string("country", 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("holidays_list");
    }
}
