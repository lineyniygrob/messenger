<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerificationUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->bearerToken()){
            return response()->json([
                'message' => 'UNAUTHORIZED'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $http = Http::connectTimeout(10)
        ->timeout(10)
        ->withToken($request->bearerToken())
        ->withHeaders(['X-Internal-Key' => config('session.internal_key')])
        ->get('http://auth-web/api/internal');

        $request->attributes->set('user', $http->json());
        return $next($request);
    }
}