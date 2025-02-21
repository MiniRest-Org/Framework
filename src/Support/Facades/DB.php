<?php

namespace MiniRestFramework\Support\Facades;

class DB extends Facade
{
    /**
     * Retorna o nome do serviço registrado no container.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'db';
    }
}