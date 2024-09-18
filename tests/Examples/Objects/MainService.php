<?php

namespace MiniRestFramework\Tests\Examples\Objects;

class MainService
{
    private $dependentService;

    public function __construct(DependentService $dependentService)
    {
        $this->dependentService = $dependentService;
    }

    public function getDependentMessage(): string
    {
        return $this->dependentService->getMessage();
    }
}