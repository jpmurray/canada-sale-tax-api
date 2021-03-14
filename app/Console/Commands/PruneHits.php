<?php

namespace App\Console\Commands;

use App\Services\Stats;
use Illuminate\Console\Command;

class PruneHits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prune:hits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune the hits table.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new Stats())->prune();

        return 1;
    }
}
