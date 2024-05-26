<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanctumAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the request is for GraphQL endpoint
        if ($request->is('graphql')) {
            // Check if the request is a mutation
            if ($request->method() === 'POST') {
                if (strpos($request['query'], 'login') !== false || strpos($request['query'], 'register') !== false) {
                    return $next($request);
                }
                // Check if the user is authenticated for mutations
                if (Auth::guard('sanctum')->guest()) {
                    return response()->json(['message' => 'Unauthenticated.'], 401);
                }
            } else {
                // Check if the user is authenticated for queries
                if (Auth::guard('sanctum')->guest()) {
                    return response()->json(['message' => 'Unauthenticated.'], 401);
                }
            }
        }

        return $next($request);
    }
}
