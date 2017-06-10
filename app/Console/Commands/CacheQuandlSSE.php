<?php

namespace App\Console\Commands;

use App\Entities\Database;
use App\Entities\Datasource;
use App\Entities\Provider;
use App\Jobs\CacheQuandlMetadata;
use Illuminate\Console\Command;

class CacheQuandlSSE extends Command
{

    public $chunkSize = 50;

    public $provider = 'Quandl';
    public $database = 'SSE';


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metacache:quandlSSE
                            {--relax : Avoid data loading if the item is in the cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes the Quandl SSE cash with histories';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $relax =$this->option('relax');

        $providerId = Provider::wherecode($this->provider)->first()->id;
        $databaseId = Database::whereCode($this->database)->first()->id;

        $datasources = Datasource::whereProviderId($providerId)->whereDatabaseId($databaseId)->get();
        foreach ($datasources->chunk($this->chunkSize) as $chunk)
        {
            $job = (new CacheQuandlMetadata($chunk, $relax))->onQueue('quandl');
            dispatch($job);
        }

        $this->info("Done. \n");
        return;
    }
}
