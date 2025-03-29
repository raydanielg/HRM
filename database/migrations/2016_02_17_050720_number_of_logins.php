<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NumberOfLogins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("admins", function(Blueprint $table) {
            $table->integer("number_of_logins")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("admins", function(Blueprint $table) {
            $table->dropColumn("number_of_logins");
        });
    }
}
