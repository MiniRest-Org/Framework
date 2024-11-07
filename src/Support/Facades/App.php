<?php

namespace MiniRestFramework\Support\Facades;

use MiniRestFramework\Foundation\Application;

class App extends Facade
{
    /**
     * Retorna o nome do serviço registrado no container.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return Application::class;
    }
}
