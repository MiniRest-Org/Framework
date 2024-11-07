<?php

use MiniRestFramework\Support\Facades\Facade;
use MiniRestFramework\Support\ServiceProvider;
use MiniRestFramework\Tests\Examples\Providers\AppServiceProvider;

return [
    'name' => 'My Application',
    'env' => 'production',
    'debug' => false,
    'root_path' => dirname(__DIR__, 1),
    'views_path' => dirname(__DIR__, 1) . '/views/',

    'providers' => ServiceProvider::defaultProvides()->merge([
        AppServiceProvider::class,
    ]),

    'aliases' => Facade::defaultAliases()->merge([
        'Test' => \MiniRestFramework\Tests\Examples\Facades\TestFacade::class
    ])
];