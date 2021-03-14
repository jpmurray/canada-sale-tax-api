<?php

namespace App\Jobs;

use App\Hit;
use App\Stat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncrementStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $endpoint;
    private $ip;
    private $user_agent;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($endpoint, $ip, $user_agent)
    {
        $this->endpoint = $endpoint;
        $this->ip = $ip;
        $this->user_agent = $user_agent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $endpointStat = Stat::firstOrCreate(['endpoint' => $this->endpoint]);
        $endpointStat->increment('hits');

        Hit::create([
            'endpoint' => $this->endpoint,
            'client' => $this->ip,
            'user_agent' => $this->user_agent,
        ]);
    }
}
