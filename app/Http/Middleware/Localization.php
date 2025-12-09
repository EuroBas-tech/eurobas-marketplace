<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Localization
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
        $locale = LaravelLocalization::getCurrentLocale();

        App::setLocale($locale);

        session()->put('locale', $locale);

        return $next($request);
    }
}
