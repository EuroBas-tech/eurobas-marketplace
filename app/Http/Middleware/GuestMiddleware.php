<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            if ($request->hasSession() && !session()->has('guest_id')) {
                $guest_id = 'guest_' . uniqid() . rand(1000, 9999);
                session()->put('guest_id', $guest_id);
                session()->save();
            }
        }
        return $next($request);
    }
}
