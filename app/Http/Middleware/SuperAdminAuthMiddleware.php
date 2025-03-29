<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminAuthMiddleware
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

        if (admin()->type === 'admin') {
            return \Redirect::route("admin.dashboard.index");
        }

        return $next($request);
    }
}
