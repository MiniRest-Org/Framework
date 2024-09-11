<?php

namespace MiniRestFramework\Bootstrappers;

use MiniRestFramework\DI\Container;
use Dotenv\Dotenv;

class LoadEnvironmentVariables
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        // Obtém a instância da classe App do container
        $app = $this->container->make('app');
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
