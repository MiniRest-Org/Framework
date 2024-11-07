<?php

namespace MiniRestFramework\Tests\Examples\Providers;

use MiniRestFramework\Support\ServiceProvider;
use MiniRestFramework\Tests\Examples\Objects\DependentService;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        // your providers
        $this->app->singleton('test', function () {
            return new DependentService();
        });
    }

    public function boot(): void
    {
    }

}