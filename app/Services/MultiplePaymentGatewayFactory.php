<?php

namespace App\Services;

use InvalidArgumentException;
use App\Interfaces\MultiplePaymentGatewayInterface;

class MultiplePaymentGatewayFactory
{
    public static function make(string $method): MultiplePaymentGatewayInterface
    {
        return match (strtolower($method)) {
            'paypal' => app(MultiplePaypalPayment::class),
            'stripe' => app(MultipleStripePayment::class),
            default => throw new InvalidArgumentException("Unsupported payment method: $method"),
        };
    }
}