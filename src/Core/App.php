<?php

namespace MiniRestFramework\Core;
use MiniRestFramework\DI\Container;
use MiniRestFramework\Http\Request\Request;
use MiniRestFramework\Router\ActionDispatcher;
use MiniRestFramework\Router\Router;
use MiniRestFramework\Router\RouterLoader;

class App {
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * @throws \ReflectionException
     */
    public function run()
    {
        $actionDispatcher = new ActionDispatcher($this->container);

        RouterLoader::load();

        $router = new Router($actionDispatcher);
        $router->dispatch(new Request())->send();
    }
}
