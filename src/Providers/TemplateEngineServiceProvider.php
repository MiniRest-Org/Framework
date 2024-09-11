<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Foundation\ServiceProvider;
use MiniRestFramework\View\TemplateEngine;

class TemplateEngineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('templateEngine', function () {
            return new TemplateEngine(config('app.views_path'));
        });
    }

    public function boot(): void
    {

    }
}