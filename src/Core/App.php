<?php

namespace MiniRestFramework\Core;
use MiniRestFramework\DI\Container;

class App {
    private Container $container;
    private static ?Container $globalContainer = null;


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
        self::$globalContainer = $container;

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

    /**
     * Obtém o container global.
     *
     * @return Container
     * @throws \Exception
     */
    public static function getContainer(): Container
    {
        if (self::$globalContainer === null) {
            throw new \Exception('Container not initialized.');
        }
        return self::$globalContainer;
    }
}
