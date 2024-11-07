<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Router\ActionDispatcher;
use MiniRestFramework\Router\Router;
use MiniRestFramework\Router\RouterLoader;
use MiniRestFramework\Support\ServiceProvider;

class RouterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ActionDispatcher::class, function () {
            return new ActionDispatcher($this->app);
        });

        $this->app->singleton(Router::class, function () {
            return new Router($this->app->make(ActionDispatcher::class));
        });
    }

    public function boot(): void
    {
        RouterLoader::load();
        $router = $this->app->make(Router::class);
        $router->dispatch(new Request())->send();
    }
}