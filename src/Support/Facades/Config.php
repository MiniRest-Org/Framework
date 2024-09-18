<?php

namespace MiniRestFramework\Support\Facades;

class Config extends Facade
{
    /**
     * Retorna o nome do serviço registrado no container.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \MiniRestFramework\config\Config::class;
    }
}
