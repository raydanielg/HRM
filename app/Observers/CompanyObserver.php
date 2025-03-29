<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\Plan;

class CompanyObserver
{
    /**
     * Handle the company "created" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function created(Company $company)
    {

        $subscriptionPlan = Plan::where('monthly_price', '0')->first();

        if($subscriptionPlan) {
            $company->subscription_plan_id = $subscriptionPlan->id;
        }
//        else {
//            $subscriptionPlan = Plan::orderBy('id', 'asc')->first();
//            $company->subscription_plan_id = $subscriptionPlan->id;
//        }

        $company->save();
    }

    /**
     * Handle the company "updated" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function updated(Company $company)
    {
        //
    }

    /**
     * Handle the company "deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the company "restored" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the company "force deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
