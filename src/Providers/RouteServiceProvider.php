<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Foundation\ServiceProvider;
use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Router\ActionDispatcher;
use MiniRestFramework\Router\Route;
use MiniRestFramework\Router\Router;
use MiniRestFramework\Router\RouterLoader;

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