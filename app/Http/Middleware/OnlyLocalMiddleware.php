<?php

namespace App\Http\Middleware;

use Closure;

class OnlyLocalMiddleware
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
        if ($request->getHttpHost() != "manageupgrade.local") {
            \App::abort(404);
        }

        return $next($request);
    }
}
