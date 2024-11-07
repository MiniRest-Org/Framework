<?php

use MiniRestFramework\Foundation\Application;

$app = (new Application())->make(Application::class);

$app->setBasePath(dirname(__DIR__));

$app->singleton(Application::class, function() use ($app) {
    return $app;
});

return $app;
