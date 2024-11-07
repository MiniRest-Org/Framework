<?php

namespace MiniRestFramework\Support\Facades;

use Illuminate\Support\Collection;
use MiniRestFramework\DI\Container;

abstract class Facade
{
    protected static ?Container $container = null;

    /**
     * Define o container do qual a facade deve buscar as instâncias.
     *
     * @param Container $container
     */
    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }

    /**
     * Obtem a instância associada à facade do container.
     *
     * @return mixed
     */
    protected static function resolveInstance()
    {
        return static::$container->make(static::getFacadeAccessor());
    }

    /**
     * Define o serviço no container para o qual a facade deve apontar.
     *
     * @return string
     */
    abstract protected static function getFacadeAccessor();

    /**
     * Redireciona as chamadas estáticas para o serviço real.
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        $instance = static::resolveInstance();

        return $instance->$method(...$arguments);
    }

    public static function defaultAliases(): Collection
    {
        return collect([
            'app' => App::class,
            'config' => Config::class,
            'view' => View::class,
            'router' => Router::class,
            'route' => Route::class,
        ]);
    }
}
