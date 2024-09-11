<?php

namespace MiniRestFramework\Bootstrappers;

use MiniRestFramework\config\Config;
use MiniRestFramework\DI\Container;

class LoadConfiguration
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        $app = $this->container->make('app');
        $basePath = $app->getBasePath();

        $this->container->singleton('config', function () use ($basePath) {
            return new Config($basePath . env('CONFIG_PATH'));
        });
    }
}
