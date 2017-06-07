<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Metadata\QuandlSSE;
use App\Repositories\Metadata\QuandlECB;

class CacheMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:cache
                            {--provider= : Name of the provider (e.g. quandl)} 
                            {--database= : Specify the providers database (e.g. SSE, ECB)}
                            {--relax : Avoid data loading if the item is in the cache}';

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
        $relax =$this->option('relax');
        $database = $this->option('database');
        
      
        if ($database == 'SSE' or $database == null)
            (new QuandlSSE($this->output))->refreshCash($relax);
         
         //Todo: implement differenciation between databaes
         
        $this->info(" Done. \n");
    }
}
