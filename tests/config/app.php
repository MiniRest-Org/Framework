<?php

return [
    'name' => 'My Application',
    'env' => 'production',
    'debug' => false,
    'root_path' => dirname(__DIR__, 1),
    'views_path' => dirname(__DIR__, 1) . '/views/',

    'providers' => [
        \MiniRestFramework\Providers\RouteServiceProvider::class,
        \MiniRestFramework\Providers\TemplateEngineServiceProvider::class
    ],

];