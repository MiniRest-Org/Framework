<?php

namespace MiniRestFramework\Tests\Examples\Facades;

use MiniRestFramework\Support\Facades\Facade;

class TestFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'test';
    }
}