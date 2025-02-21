<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Http\Request\SanitizeService;
use MiniRestFramework\Router\ActionDispatcher;
use MiniRestFramework\Router\Router;
use MiniRestFramework\Router\RouterLoader;
use MiniRestFramework\Support\ServiceProvider;

class RouterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registrar o SanitizeService no contêiner
        $this->app->singleton(SanitizeService::class, function() {
            return new SanitizeService();
        });

        $this->app->singleton(ActionDispatcher::class, function () {
            return new ActionDispatcher($this->app);
        });

        $this->app->singleton(Router::class, function () {
            return new Router($this->app->make(ActionDispatcher::class));
        });

        // Registrar o Request com injeção de dependência para o SanitizeService
        $this->app->singleton(Request::class, function () {
            return new Request($this->app->make(SanitizeService::class));
        });
    }

    public function boot(): void
    {
        RouterLoader::load();
        $router = $this->app->make(Router::class);
        $router->dispatch($this->app->make(Request::class))->send();
    }
}