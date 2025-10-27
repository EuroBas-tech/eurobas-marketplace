<?php

namespace App\Http\Middleware;

use Closure;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            session()->put('currency_code','EUR');
             session()->put('currency_symbol','€');
            session()->put('currency_exchange_rate',1.0);
            return $next($request);
        }else{
            abort(404);
        }
    }
}
