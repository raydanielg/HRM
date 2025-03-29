<?php

use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        DB::table('subscription_plans')->truncate(); // deleting old records.

        \App\Models\Plan::create([
            'plan_name' => 'Basic',
            'stripe_monthly_plan_id' => 'hrm_basic_plan_monthly',
            'stripe_annual_plan_id' => 'hrm_basic_plan_annual',
            'start_user_count' => 0,
            'end_user_count' => 30,
            'monthly_price' => 0,
            'annual_price' => 0,
        ]);

        \App\Models\Plan::create([
            'plan_name' => 'Advanced',
            'stripe_monthly_plan_id' => 'hrm_advanced_plan_montly',
            'stripe_annual_plan_id' => 'hrm_advanced_plan_annual',
            'start_user_count' => 31,
            'end_user_count' => 50,
            'monthly_price' => 25,
            'annual_price' => 250,
        ]);

        \App\Models\Plan::create([
            'plan_name' => 'Premium',
            'stripe_monthly_plan_id' => 'hrm_premium_plan_montly',
            'stripe_annual_plan_id' => 'hrm_premium_plan_annual',
            'start_user_count' => 51,
            'end_user_count' => 60,
            'monthly_price' => 100,
            'annual_price' => 1000,
        ]);


        DB::commit();
    }
}
