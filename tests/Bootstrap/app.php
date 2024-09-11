<?php

use MiniRestFramework\Core\App;

$container = new \MiniRestFramework\DI\Container();

$container->singleton('app', function() use ($container) {
    return new App($container);
});

$app = $container->make('app');

$app->setBasePath(dirname(__DIR__));

return $app;
