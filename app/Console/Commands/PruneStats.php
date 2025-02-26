<?php

namespace App\Console\Commands;

use App\Models\Hit;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class PruneStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune the logged hits.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Hit::where('created_at', '<', Carbon::now()->subMonth(config('api.retention.hits')))->delete();
    }
}
