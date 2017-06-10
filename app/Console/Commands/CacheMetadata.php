<?php

namespace App\Console\Commands;

use App\Entities\Provider;
use App\Jobs\CacheQuandlMetadata;
use Illuminate\Console\Command;

class CacheMetadata extends Command
{

    public $chunkSize = 50;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metadata:cache
                            {--provider= : Name of the provider (Quandl)} 
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

            $datasources = Provider::whereCode('Quandl')->first()->datasources;
            foreach ($datasources->chunk($this->chunkSize) as $chunk)
            {
                $job = (new CacheQuandlMetadata($chunk, $relax))->onQueue('quandl');
                dispatch($job);
            }
        }

        $this->info("Done. \n");
        return;
    }
}
