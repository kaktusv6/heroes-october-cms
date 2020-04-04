<?php declare(strict_types=1);

namespace Nkf\Heroes\Classes\Api;

use Exception;
use Nkf\Heroes\Api\ApiException;
use October\Rain\Foundation\Exception\Handler;

class ApiExceptionHandler extends Handler
{
    protected $dontReport = [
        // Main exceptions
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,

        // Custom exceptions
        ApiException::class,
    ];

    public function render($request, Exception $exception)
    {
        if ($exception instanceof ApiException) {
            return response()->json($exception->getErrors(), $this->getStatusCode($exception));
        }

        return parent::render($request, $exception);
    }

    public function report(Exception $exception): void
    {
        parent::report($exception);
    }
}
