<?php

namespace MiniRestFramework\Foundation\Bootstrap;

use MiniRestFramework\config\Config;
use MiniRestFramework\DI\Container;
use MiniRestFramework\Foundation\Application;

class LoadConfiguration
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        $app = $this->container->make(Application::class);
        $basePath = $app->getBasePath();

        $this->container->singleton(Config::class, function () use ($basePath) {
            return new Config($basePath . env('CONFIG_PATH'));
        });
    }
}
