<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CombinePriceColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("license_types", function(Blueprint $table) {
            $table->dropColumn("per_user_monthly_price");
            $table->dropColumn("one_time_fees");
            $table->decimal("price", 8, 2)->after("free_users");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
