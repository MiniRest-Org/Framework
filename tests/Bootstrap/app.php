<?php

use MiniRestFramework\config\Config;
use MiniRestFramework\Core\App;
use MiniRestFramework\DI\ContainerManager;
use MiniRestFramework\View\TemplateEngine;

$container = new \MiniRestFramework\DI\Container();

$container->singleton(Config::class, function () {
    return new Config(dirname(__DIR__, 2) . '/tests/config/');
});

ContainerManager::set('container', $container);
ContainerManager::set('config', $container->get(Config::class));

$container->singleton(TemplateEngine::class, function () {
    return new TemplateEngine(config('app.views_path'));
});

ContainerManager::set('templateEngine', $container->get(TemplateEngine::class));


$app = new App($container);

return $app;
