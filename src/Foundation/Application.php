<?php

namespace MiniRestFramework\Foundation;
use MiniRestFramework\DI\Container;

class Application extends Container  {

    protected array $bootstrappers = [
        \MiniRestFramework\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \MiniRestFramework\Foundation\Bootstrap\LoadConfiguration::class,
        \MiniRestFramework\Foundation\Bootstrap\RegisterFacades::class,
        \MiniRestFramework\Foundation\Bootstrap\RegisterProviders::class,
        \MiniRestFramework\Foundation\Bootstrap\BootProviders::class,
    ];

    protected array $providers = [];
    private string $base_path;

    protected static $instance;

    public function __construct()
    {
        // Definir a instância atual como o singleton
        static::$instance = $this;
    }

    public function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper($this))->bootstrap();
        }
    }

    public function run()
    {
        // Bootstrap the framework (load configurations, etc.)
        $this->bootstrap();

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
     * Get the path to the storage directory.
     *
     * @param  string  $path
     * @return string
     */
    public function storagePath($path = '')
    {
        return $this->base_path . '/storage/' . $path;
    }

    public static function getContainer(): static
    {
        $app = Application::getInstance(); // Supondo que sua classe Application tem esse método
        return $app->make(Application::class); // Use o método make() da instância
    }

    // Método estático para retornar a instância da aplicação
    public static function getInstance()
    {
        return static::$instance;
    }
}
