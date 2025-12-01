<?php

namespace App\Jobs;

use App\Models\Hit;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessHits implements ShouldQueue
{
    use Queueable;

    private $version;
    private $endpoint;
    private $ip;
    private $user_agent;
    private $user;
    private $status_code;

    /**
     * Create a new job instance.
     */
    public function __construct($version, $endpoint, $ip, $user_agent, $user = null, $status_code = null)
    {
        $this->version = strtolower($version);
        $this->endpoint = strtolower($endpoint);
        $this->ip = $ip;
        $this->user_agent = $user_agent;
        $this->user = $user;
        $this->status_code = $status_code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $usage = Usage::firstOrCreate(['version' => $this->version, 'endpoint' => $this->endpoint]);
        $usage->increment('count');

        if ($this->user) {
            $this->user->hits()->create([
                'version' => $this->version,
                'endpoint' => $this->endpoint,
                'client' => $this->ip,
                'user_agent' => $this->user_agent,
                'status_code' => $this->status_code,
            ]);
        } else {
            Hit::create([
                'version' => $this->version,
                'endpoint' => $this->endpoint,
                'client' => $this->ip,
                'user_agent' => $this->user_agent,
                'status_code' => $this->status_code,
            ]);
        }
        // dd($this->version, $this->endpoint, $this->ip, $this->user_agent, $this->user);

    }
}
