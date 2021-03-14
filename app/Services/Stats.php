<?php

namespace App\Services;

use App\Hit;
use App\Jobs\IncrementStats;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Stats
{
    private $request;
    private $endpoint;
    private $ip;
    private $user_agent;
    private $prune_months = 6;

    public function __construct()
    {
        return $this;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;

        $this->endpoint = strtolower($this->request->path());
        $this->ip = $this->request->ip();
        $this->user_agent = $this->request->hasHeader('user_agent') ? $this->request->header('user_agent') : null;

        return $this;
    }

    public function dispatch()
    {
        dispatch(new IncrementStats($this->endpoint, $this->ip, $this->user_agent));

        return $this;
    }

    public function prune()
    {
        Hit::where('created_at', '<', Carbon::now()->subMonth($this->prune_months))->delete();
    }
}
