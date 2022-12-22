<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(
                [
                    'status' => false,
                    'error' => 'Invalid endpoint, please read the documentation.',
                    'code' => 404
                ],
                404
            );
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'status' => false,
                'error' => 'Method Not Allowed',
                'allowed_method' => "GET",
                'code' => 405
            ], 405);
        } elseif ($exception instanceof QueryException) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error',
                'code' => 500
            ], 500);
        } elseif ($exception instanceof HttpException) {
            return response()->json([
                'status' => false,
                'error' => 'Internal Server Error',
                'code' => 500
            ], 500);
        }


        return parent::render($request, $exception);
    }

    // public function render($request, Throwable $exception)
    // {
    //     return parent::render($request, $exception);
    // }
}
