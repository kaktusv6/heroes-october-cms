<?php declare(strict_types=1);

namespace Nkf\Heroes\Classes\Services;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Nkf\Heroes\Classes\Api\ApiExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(
            ExceptionHandler::class,
            ApiExceptionHandler::class
        );
    }

    public function register(): void
    {

    }
}
