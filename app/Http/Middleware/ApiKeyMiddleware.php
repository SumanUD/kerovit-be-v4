<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $providedKey = $request->header('X-API-KEY');
        $expectedKey = env('API_SECRET_KEY');

        if ($providedKey !== $expectedKey) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
