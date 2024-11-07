<?php

namespace MiniRestFramework\Foundation\Bootstrap;

use Dotenv\Dotenv;
use MiniRestFramework\DI\Container;
use MiniRestFramework\Foundation\Application;

class LoadEnvironmentVariables
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws \Exception
     */
    public function bootstrap()
    {
        // Obtém a instância da classe App do container
        $app = $this->container->make(Application::class);
        $basePath = $app->getBasePath();

        // Localiza o arquivo .env
        $dotenvPath = $basePath . '/.env';

        // Carrega as variáveis de ambiente do arquivo .env
        if (file_exists($dotenvPath)) {
            $dotenv = Dotenv::createImmutable($basePath);
            $dotenv->load();
        } else {
            throw new \Exception('Arquivo .env não encontrado no caminho base.');
        }
    }
}
