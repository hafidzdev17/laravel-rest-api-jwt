<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// namespace for jwt middleware
use Tymon\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $err) {
            if ($err instanceof TokenInvalidException) {
                return response()->json(['status' => 'Token is invalid']);
            } else if  ($err instanceof TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired']);
            }
            return response()
                ->json(['status' => 'Authorization Token not found']);
        }
        return $next($request);
    }
}
