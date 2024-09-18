<?php

use MiniRestFramework\Core\App;

$container = new \MiniRestFramework\DI\Container();

$container->singleton(App::class, function() use ($container) {
    return new App($container);
});

$app = $container->make(App::class);

$app->setBasePath(dirname(__DIR__));

return $app;
