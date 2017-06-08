<?php

namespace App\Jobs;

use App\Repositories\Quandl\Quandldata;
use App\Entities\Datasource;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CacheQuandlMetadata implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $datasources;
    protected $relax;

    /**
     * Create a new job instance.
     *
     * @param Datasource $datasources
     * @param bool $relax
     */
    public function __construct($datasources, $relax)
    {
        $this->datasources = $datasources;
        $this->relax = $relax;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->datasources as $datasource)
        {
            $code = $datasource->dataset->code;
            Quandldata::refreshCache($code, $this->relax);
        }
    }
}
