<?php

namespace App\Http\Middleware;

use Closure;
use App\Jobs\ProcessHits;
use Illuminate\Http\Request;
use App\Traits\RequestProcessor;
use Symfony\Component\HttpFoundation\Response;

class RegisterHit
{
    use RequestProcessor;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $version = $this->getAPIVersion($request);
        $endpoint = $this->getEndpoint($request);
        $ip = $this->getIP($request);
        $user_agent = $this->getUserAgent($request);

        ProcessHits::dispatch($version, $endpoint, $ip, $user_agent, $request->user());

        return $next($request);
    }
}
