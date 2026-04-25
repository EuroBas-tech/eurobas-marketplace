<?php

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Trust all proxies - Essential for AWS Load Balancers.
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * Use all X-Forwarded headers to detect correct protocol (HTTPS) and IP.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
