<?php

namespace MiniRestFramework\Bootstrappers;

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
        $config = $this->container->make('config');
        $providers = $config->get('app.providers') ?? [];

        foreach ($providers as $provider) {
            $instance = $this->container->make($provider);
            $instance->boot();
        }
    }
}
