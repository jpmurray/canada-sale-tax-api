<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class DeprecationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Endpoints whose sunset date has passed are permanently blocked and return
     * HTTP 410 Gone with standards-aligned Deprecation, Sunset, and Link headers
     * (see RFC 8594 and draft-ietf-httpapi-deprecation-header).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $version = null): Response
    {
        $deprecationDate = Carbon::createFromFormat('Y-m-d', config('api.deprecation.' . $version . '.date'));
        $sunsetDate = Carbon::createFromFormat('Y-m-d', config('api.sunset.' . $version . '.date'));

        $headers = [
            'Deprecation' => $deprecationDate->toRfc7231String(),
            'Sunset'      => $sunsetDate->toRfc7231String(),
            'Link'        => '<https://salestaxapi.ca/>; rel="successor-version"',
        ];

        // Once the sunset date has passed the API version is permanently gone.
        // Return 410 Gone (RFC 7231 §6.5.9) – deterministic, no random behaviour.
        if (Carbon::now()->greaterThanOrEqualTo($sunsetDate)) {
            $message = 'Version ' . $version . ' of the API has been permanently removed as of '
                . $sunsetDate->toRfc7231String()
                . '. Please refer to the documentation at https://salestaxapi.ca/ for the current API.';

            return response()
                ->json(['message' => $message], 410)
                ->withHeaders($headers);
        }

        // Before sunset: allow the request through but advertise the upcoming removal.
        $response = $next($request);

        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value);
        }

        return $response;
    }
}
