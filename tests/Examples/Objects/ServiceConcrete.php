<?php

namespace MiniRestFramework\Tests\Examples\Objects;

use MiniRestFramework\Tests\Examples\Contracts\ServiceInterface;

class ServiceConcrete implements ServiceInterface
{
    public function execute(): string
    {
        return "ServiceConcrete executed";
    }
}