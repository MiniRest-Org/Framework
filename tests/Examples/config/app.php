<?php

return [
    'name' => 'My Application',
    'env' => 'production',
    'debug' => false,
    'root_path' => dirname(__DIR__, 1),
    'views_path' => dirname(__DIR__, 1) . '/views/',

    'providers' => \MiniRestFramework\Foundation\ServiceProvider::defaultProvides()->merge([

    ]),

    'aliases' => \MiniRestFramework\Support\Facades\Facade::defaultAliases()->merge([

    ])
];