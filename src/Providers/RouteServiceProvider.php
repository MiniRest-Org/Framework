<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Router\Route;
use MiniRestFramework\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Route::class, function () {
            return new Route();
        });
    }

    public function boot(): void
    {

    }
}