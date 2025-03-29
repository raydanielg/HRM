<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

if (!function_exists("help_text")) {

    function help_text($name, $direction = "right") {

        $detect = new Mobile_Detect();

        $title = trans("help.".$name.".title");
        $text = trans("help.".$name.".text");

        if ($detect->isMobile()) {
            $string = '<span class="badge badge-danger popovers" data-html="true" data-container="body" data-trigger="hover" data-placement="bottom" data-content="' . $text . '" data-original-title="' . $title . '" title=""><i class="fa fa-question"></i></span>';
        }
        else {
            $string = '<span class="badge badge-danger popovers" data-html="true" data-container="body" data-trigger="hover" data-placement="'.$direction.'" data-content="' . $text . '" data-original-title="' . $title . '" title=""><i class="fa fa-question"></i></span>';

        }

        return $string;
    }
}

if(!defined("PP_CONFIG_PATH")) {
    define("PP_CONFIG_PATH", storage_path()."/app");
}

return $app;
