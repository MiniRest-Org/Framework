<?php

namespace MiniRestFramework\Tests\Examples\Objects;

use MiniRestFramework\Tests\Examples\Contracts\PaymentGatewayInterface;

class StripeGateway implements PaymentGatewayInterface
{
    public function processPayment(): string
    {
        return "Processed by Stripe";
    }
}