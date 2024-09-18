<?php

namespace MiniRestFramework\Support\Facades;

class Router extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MiniRestFramework\Router\Route::class;
    }
}
