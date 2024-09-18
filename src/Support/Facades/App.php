<?php

namespace MiniRestFramework\Support\Facades;

class App extends Facade
{
    /**
     * Retorna o nome do serviço registrado no container.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \MiniRestFramework\Core\App::class;
    }
}
