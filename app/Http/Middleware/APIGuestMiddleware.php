<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIGuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization') && auth('api')->check()) {
            $request->merge(['user' => auth('api')->user()]);
            return $next($request);
        }

        if ($request->guest_id) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
