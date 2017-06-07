<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Metadata\QuandlSSE;

class CacheMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:cache
                            {--provider= : Name of the provider (e.g. quandl)} 
                            {--database= : Specify the providers database (e.g. SSE, ECB)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes the cash with histories from data provider';

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
     * @return mixed
     */
    public function handle()
    {
        $meta = new QuandlSSE($this->output);
        $meta->refreshCash();

        $this->info(" Done. \n");
    }
}
