<?php

namespace MiniRestFramework\Tests\Examples\Objects;

class SingletonTestService
{
    public $randomNumber;

    public function __construct()
    {
        $this->randomNumber = rand();
    }
}