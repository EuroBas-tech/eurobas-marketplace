<?php

namespace App\Interfaces;

use App\Model\SponsoredAd;

interface PaymentGatewayInterface
{
    public function pay(SponsoredAd $sponsor);
}
