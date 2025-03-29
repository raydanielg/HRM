<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthMiddleware
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

        if (!admin()) {
            return \Redirect::route("login");
        }

        if (admin()->type === 'superadmin') {
            return \Redirect::route("superadmin.dashboard.index");
        }


        return $next($request);
    }
}
