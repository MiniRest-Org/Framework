<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Database\DatabaseConnection;
use MiniRestFramework\Foundation\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(DatabaseConnection::class, function () {
            return new DatabaseConnection(
                config('database'),
            );
        });
    }

    public function boot(): void
    {
    }
}