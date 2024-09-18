<?php

namespace MiniRestFramework\Support\Facades;



use MiniRestFramework\View\TemplateEngine;

class View extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TemplateEngine::class;
    }
}
