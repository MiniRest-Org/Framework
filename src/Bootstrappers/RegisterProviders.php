<?php

namespace MiniRestFramework\Bootstrappers;

use MiniRestFramework\DI\Container;

class RegisterProviders
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
            $instance = new $provider($this->container);
            $instance->register();

            // O provider é adicionado ao container para uso posterior
            $this->container->singleton($provider, function () use ($provider) {
                return new $provider($this->container);
            });
        }
    }
}