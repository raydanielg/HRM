<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;

class PlanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $admin = admin();
        if ($admin && $admin->type !== 'superadmin') {
            $company = Company::find($admin->company_id);
            if(is_null($company->subscription_plan_id)) {
                return \Redirect::route("admin.billing.change_plan");
            }
        }

        return $next($request);
    }
}
