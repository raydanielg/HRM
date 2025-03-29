<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function(Blueprint $table)
        {
            $table->dropColumn('stripe_id');
            $table->dropColumn('price');
        });

        Schema::table('subscription_plans', function(Blueprint $table)
        {
            $table->double('monthly_price')->after('end_user_count');
            $table->double('annual_price')->after('monthly_price');
            $table->string('stripe_annual_plan_id')->after('annual_price');
            $table->string('stripe_monthly_plan_id')->after('stripe_annual_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function(Blueprint $table)
        {
            $table->dropColumn('monthly_price');
            $table->dropColumn('annual_price');
            $table->dropColumn('stripe_annual_plan_id');
            $table->dropColumn('stripe_monthly_plan_id');
        });
    }
}
