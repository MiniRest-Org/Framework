<?php

namespace MiniRestFramework\Providers;

use MiniRestFramework\Database\DatabaseConnection;
use MiniRestFramework\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(DatabaseConnection::class, function () {
            return new DatabaseConnection(
                config('database'),
            );
        });

        $this->app->singleton('db', function () {
            return new \Illuminate\Database\Capsule\Manager();
        });
    }

    public function boot(): void
    {
    }
}