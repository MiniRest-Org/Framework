<?php

namespace MiniRestFramework\Tests\Examples\Contracts;

interface PaymentGatewayInterface
{
    public function processPayment(): string;
}