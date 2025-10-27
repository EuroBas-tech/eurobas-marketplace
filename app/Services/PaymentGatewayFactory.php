<?php

namespace App\Services;

use InvalidArgumentException;
use App\Interfaces\PaymentGatewayInterface;

class PaymentGatewayFactory
{
    public static function make(string $method): PaymentGatewayInterface
    {
        return match (strtolower($method)) {
            'paypal' => app(PaypalPayment::class),
            'stripe' => app(StripePayment::class),
            default => throw new InvalidArgumentException("Unsupported payment method: $method"),
        };
    }
}