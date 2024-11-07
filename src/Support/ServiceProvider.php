<?php

namespace MiniRestFramework\Support;

abstract class ServiceProvider
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    abstract public function register();

    abstract public function boot();

    public static function defaultProvides() {
        return collect([
            \MiniRestFramework\Providers\RouterServiceProvider::class,
            \MiniRestFramework\Providers\RouteServiceProvider::class,
            \MiniRestFramework\Providers\TemplateEngineServiceProvider::class,
            \MiniRestFramework\Providers\DatabaseServiceProvider::class
        ]);
    }
}
