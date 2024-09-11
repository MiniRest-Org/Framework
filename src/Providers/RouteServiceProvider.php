<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Foundation\ServiceProvider;
use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Router\ActionDispatcher;
use MiniRestFramework\Router\Router;
use MiniRestFramework\Router\RouterLoader;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ActionDispatcher::class, function () {
            return new ActionDispatcher($this->app);
        });

        $this->app->singleton('router', function () {
            return new Router($this->app->make(ActionDispatcher::class));
        });
    }

    public function boot(): void
    {
        RouterLoader::load();
        $router = $this->app->make('router');
        $router->dispatch(new Request())->send();
    }
}