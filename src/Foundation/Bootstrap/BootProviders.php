<?php

namespace MiniRestFramework\Foundation\Bootstrap;

use MiniRestFramework\config\Config;
use MiniRestFramework\DI\Container;

class BootProviders
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        $config = $this->container->make(Config::class);
        $providers = $config->get('app.providers') ?? [];

        foreach ($providers as $provider) {
            $instance = $this->container->make($provider);
            $instance->boot();
        }
    }
}
