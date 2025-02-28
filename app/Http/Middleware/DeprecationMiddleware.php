<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $deprecationDate = Carbon::createFromFormat('Y-m-d', config('api.deprecation.' . $version . '.date'));
        $sunsetDate = Carbon::createFromFormat('Y-m-d', config('api.sunset.' . $version . '.date'));
        $message = 'Version ' . $version . ' of the API will be sunsetted on ' . $sunsetDate->toRfc7231String() . '.';

        $response->headers->set('X-Deprecation-Notice', $message);
        $response->headers->set('Deprecation', $deprecationDate->toRfc7231String());
        $response->headers->set('Sunset', $sunsetDate->toRfc7231String());

        if (mt_rand(1, 100) <= config('api.deprecation.' . $version . '.rate')) {
            $response->setStatusCode(402); // sending subset of requests a non standard code to catch their attention
        }

        return $response;
    }
}
