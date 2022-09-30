<?php

namespace App\Exceptions;

use App\Traits\ResponseApi;
use Throwable;
use Psr\Log\LogLevel;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ResponseApi;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $response = $this->handleException($request, $e);
        return $response;
    }

    public function handleException($request, Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->sendError('The specified method for the request is invalid', 405);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->sendError('The specified URL cannot be found', 404);
        }

        if ($e instanceof HttpException) {
            return $this->sendError($e->getMessage(), $e->getStatusCode());
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->sendError('Unexpected Exception. Try later', 500);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param Request $request
     * @param AuthenticationException $e
     * @return JsonResponse|RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->segment(1) == 'api'
            ? response()->json([
                'message' => 'Please Login To Access This Url',
                'code' => 401,
                'success' => false,
                'data' => []
            ], 401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}
