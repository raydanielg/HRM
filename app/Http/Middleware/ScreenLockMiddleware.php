<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ScreenLockMiddleware
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
        if (\Cookie::get('lock') == '1') {
            if ($request == route('admin.login') || $request == route('admin.logout')) {
                return $next($request);
            } else {
                return \Redirect::route('admin.screen.lock');
            }
        }

        return $next($request);
    }
}
