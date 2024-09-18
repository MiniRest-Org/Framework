<?php

namespace MiniRestFramework\Tests\Examples\Objects;

class ExampleService
{
    private ExampleRepository $exampleRepository;

    public function __construct(
        ExampleRepository $exampleRepository
    )
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function getRepository() {
        return $this->exampleRepository;
    }

    public function doSomething()
    {
        return "Service is working!";
    }

    public function sayHello(): string {
        return "Hello from ExampleService!";
    }
}