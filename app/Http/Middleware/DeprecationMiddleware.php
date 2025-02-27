<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\HttpFoundation\Response;

class DeprecationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, String $version = null): Response
    {
        $response = $next($request);

        if ($version === 'v1') {
            $response->headers->set('X-Deprecation-Notice', 'Version 1 of the API will be deprecated on July 1st, 2025.');
        }

        if ($version === 'v2') {
            $response->headers->set('X-Deprecation-Notice', 'Version 2 of the API will be deprecated on December 1st, 2025.');
        }

        return $response;

        // return $next($request);
    }
}
