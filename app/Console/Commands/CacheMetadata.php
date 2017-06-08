<?php

namespace App\Console\Commands;

use App\Jobs\CacheQuandlMetadata;
use Illuminate\Console\Command;
use App\Repositories\Metadata\QuandlCaching;

class CacheMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:cache
                            {--provider= : Name of the provider (e.g. quandl)} 
                            {--relax : Avoid data loading if the item is in the cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes the cash with histories from data provider';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $relax =$this->option('relax');
        $provider = $this->option('provider');

        if (!in_array($provider, ['Quandl', null])) {
            $this->comment("Provider {$provider} not defined.");
            return;
        }
      
        if ($provider == 'Quandl' or $provider == null) {
            dispatch(new CacheQuandlMetadata($relax));
        }

        $this->info("Done. \n");
        return;
    }
}
