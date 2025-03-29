<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LicensesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("license_types", function(Blueprint $table) {
            $table->increments("id");
            $table->string("name", 30);
            $table->string("description", 500);
            $table->tinyInteger("free_users");
            $table->decimal("per_user_monthly_price", 5, 2);
            $table->decimal("one_time_fees", 6, 2);
            $table->enum("type", ["Cloud", "Multi-Company", "On-Premise"])->default("Cloud");
            $table->enum("status", ["Enabled", "Disabled"])->default("Enabled");
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
        Schema::dropIfExists("license_types");
    }
}
