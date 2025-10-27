<?php

namespace App\Interfaces;

use App\Model\SponsoredAd;

interface MultiplePaymentGatewayInterface
{
    public function pay(SponsoredAd $sponsor);
}
