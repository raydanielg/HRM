<?php

/*
|--------------------------------------------------------------------------
| Register Namespaces And Routes
|--------------------------------------------------------------------------
|
| When a module starting, this file will executed automatically. This helps
| to register some namespaces like translator or view. Also this file
| will load the routes file for each module. You may also modify
| this file as you want.
|
*/

use Illuminate\Support\Str;

if (!function_exists('user')) {

    /**
     * Return current logged in user
     */
    function user()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('employees')->user();

        if (is_a($user, \App\Models\Employee::class)) {
            session('user', $user);

            return $user;
        }

        return null;

    }

}

if (!function_exists('employee')) {

    /**
     * Return current logged in user
     */
    function employee()
    {
        $user = \Illuminate\Support\Facades\Auth::guard('employee')->user();

        if (is_a($user, \App\Models\Employee::class)) {
            session('user', $user);

            return $user;
        }

        return null;

    }

}


if (!function_exists('admin')) {

    /**
     * @return null
     */
    function admin()
    {
        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();
        if (is_a($admin, 'App\Models\Admin')) {
            session('admin', $admin);
            return $admin;
        }

        return null;

    }

}

if (!function_exists('asset_url')) {

    // @codingStandardsIgnoreLine
    function asset_url($path)
    {
        $path = 'uploads/' . $path;
        $storageUrl = $path;

        if (!Str::startsWith($storageUrl, 'http')) {
            return url($storageUrl);
        }

        return $storageUrl;

    }

}
