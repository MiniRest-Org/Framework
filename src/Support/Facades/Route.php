<?php

namespace MiniRestFramework\Support\Facades;

class Route extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MiniRestFramework\Router\Route::class;
    }
}
