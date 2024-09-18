<?php

namespace MiniRestFramework\Tests\Examples\Objects;

class DependentService
{
    public function getMessage(): string
    {
        return "Dependent service message";
    }
}