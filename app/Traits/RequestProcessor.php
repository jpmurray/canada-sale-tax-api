<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait RequestProcessor
{
    public function getAPIVersion(Request $request)
    {
        return $this->extractor($request)['version'];
    }

    public function getEndpoint(Request $request)
    {
        return $this->extractor($request)['endpoint'];
    }

    public function getIP(Request $request)
    {
        return $request->ip();
    }

    public function getUserAgent(Request $request)
    {
        return $request->hasHeader('user_agent') ? $request->header('user_agent') : null;
    }

    private function extractor(Request $request)
    {
        $segments = explode('/', $request->path());
        $version = null;

        foreach ($segments as $key => $segment) {
            if (strpos($segment, 'v') === 0) {
                $version = $segment;
                unset($segments[$key]);
                break;
            }
        }

        $endpoint = implode('/', $segments); // Reconstruct the URL without the version segment

        return [
            'version' => $version,
            'endpoint' => $endpoint
        ];
    }
}
