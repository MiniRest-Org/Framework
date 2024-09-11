<?php

namespace MiniRestFramework\Core;
use MiniRestFramework\DI\Container;

class App {
    private Container $container;

    protected array $bootstrappers = [
        \MiniRestFramework\Bootstrappers\LoadEnvironmentVariables::class,
        \MiniRestFramework\Bootstrappers\LoadConfiguration::class,
        \MiniRestFramework\Bootstrappers\RegisterFacades::class,
        \MiniRestFramework\Bootstrappers\RegisterProviders::class,
        \MiniRestFramework\Bootstrappers\BootProviders::class,
    ];

    protected array $providers = [];
    private string $base_path;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper($this->container))->bootstrap();
        }
    }

    public function run()
    {
        // Bootstrap the framework (load configurations, etc.)
        $this->bootstrap();;

    }

    public function getBasePath(): string
    {
        return $this->base_path;
    }

    public function setBasePath(string $base_path): void
    {
        $this->base_path = $base_path;
    }
}
