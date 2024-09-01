<?php

namespace MiniRestFramework\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseConnection
{
    private Capsule $capsule;

    /**
     * Constructor.
     *
     * @param array $config Configurações de conexão do banco de dados.
     */
    public function __construct(array $config)
    {
        $this->setupEloquent($config);
    }

    /**
     * Configura o Eloquent ORM.
     *
     * @param array $config Configurações de conexão do banco de dados.
     * @return void
     */
    private function setupEloquent(array $config): void
    {
        $this->capsule = new Capsule;

        $defaultConnection = $config['default'];
        $connectionConfig = $config['connections'][$defaultConnection];

        $this->capsule->addConnection($connectionConfig);

        // Torna o Eloquent globalmente acessível
        $this->capsule->setAsGlobal();

        // Inicializa os eventos de Eloquent
        $this->capsule->bootEloquent();
    }

    /**
     * Obtém o gerenciador de conexão do Eloquent.
     *
     * @return Capsule O gerenciador de conexão.
     */
    public function getCapsule(): Capsule
    {
        return $this->capsule;
    }
}