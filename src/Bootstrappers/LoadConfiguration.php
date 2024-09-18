<?php

namespace MiniRestFramework\Bootstrappers;

use MiniRestFramework\config\Config;
use MiniRestFramework\Core\App;
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
        $app = $this->container->make(App::class);
        $basePath = $app->getBasePath();

        $this->container->singleton(Config::class, function () use ($basePath) {
            return new Config($basePath . env('CONFIG_PATH'));
        });
    }
}
