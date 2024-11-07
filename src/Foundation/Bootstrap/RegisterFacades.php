<?php

namespace MiniRestFramework\Foundation\Bootstrap;

use MiniRestFramework\config\Config;
use MiniRestFramework\DI\Container;
use MiniRestFramework\Foundation\AliasLoader;
use MiniRestFramework\Support\Facades\Facade;

class RegisterFacades
{
    protected Container $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function bootstrap(): void
    {
        $config = $this->app->make(Config::class);

        // Configura o container para cada alias
        foreach ($config->get('app.aliases') as $alias => $facade) {
            if (class_exists($facade)) {
                Facade::setContainer($this->app);

                $this->app->singleton($alias, function () use ($facade) {
                    return new $facade;
                });
            }
        }

        AliasLoader::getInstance(
            $config->get('app.aliases')->toArray(),
        )->register();
    }
}
