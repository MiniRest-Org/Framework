<?php

namespace MiniRestFramework\Router;

class RouterLoader
{
    public static function load(): void
    {
        $routersPath = config('app.root_path') . '/routers/';

        $routerFiles = glob($routersPath . '*.php');

        foreach ($routerFiles as $file) {
            require_once $file;
        }
    }
}