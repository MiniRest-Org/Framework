<?php

namespace MiniRestFramework\Bootstrappers;

use MiniRestFramework\DI\Container;
use MiniRestFramework\Support\Facades\Facade;

class RegisterFacades
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bootstrap()
    {
        Facade::setContainer($this->container);
    }
}
