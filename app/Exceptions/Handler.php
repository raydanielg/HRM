<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        Log::error($e);
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof TokenMismatchException && \Request::ajax()) {
            return \Response::json([
                "status" => "fail",
                "type" => "TokenMismatchException",
                "message" => "Your session token has expired. Please refresh page and try again!"
            ]);
        }
        if($this->isHttpException($e)){
            if (Request::is('admin/*')) {
                switch ($e->getStatusCode()) {
                    case '404':
                        if (env("APP_ENV") == "production") {
                            Log::error($e);
                        }

                        return \Response::view('admin.errors.404');
                        break;

                    case '500':
                        if (env("APP_ENV") == "production") {
                            Log::error($e);
                        }

                        return \Response::view('admin.errors.500');
                        break;
                    case '403':
                        if (env("APP_ENV") == "production") {
                            Log::error($e);
                        }

                        return \Response::view('admin.errors.403');
                        break;
                    default:
                        return $this->renderHttpException($e);
                        break;
                }
            }else if (Request::is('*')){
                switch ($e->getStatusCode()) {
                    case '404':
                        if (env("APP_ENV") == "production") {
                            Log::error($e);
                        }

                        return \Response::view('front.errors.404');
                        break;
                    case '403':
                        if (env("APP_ENV") == "production") {
                            Log::error($e);
                        }

                        return \Response::view('front.errors.403');
                        break;

                    case '500':
                        if (env("APP_ENV") == "production") {
                            Log::error($e);
                        }

                        return \Response::view('front.errors.500');
                        break;

                    default:
                        return $this->renderHttpException($e);
                        break;
                }
            }
        }
        else
        {
            return parent::render($request, $e);
        }


        // return parent::render($request, $e);
    }


}
