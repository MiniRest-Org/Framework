<?php

namespace MiniRestFramework\Bootstrappers;

use MiniRestFramework\config\Config;
use MiniRestFramework\DI\Container;
use MiniRestFramework\Support\Facades\Facade;

class RegisterFacades
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {

        $config = $this->container->make(Config::class);

        // Configura o container para cada alias
        foreach ($config->get('app.aliases') as $alias => $facade) {
            if (class_exists($facade)) {
                Facade::setContainer($this->container);
                $this->container->singleton($alias, function () use ($facade) {
                    return new $facade;
                });
            }
        }

//        // Configura o alias de facades para o container
//        foreach ($config->get('app.aliases') as $alias => $facade) {
//            class_alias($facade, $alias);
//        }

    }
}
