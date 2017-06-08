<?php

namespace App\Jobs;

use App\Repositories\Metadata\QuandlCaching;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CacheQuandlMetadata implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $relax;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($relax)
    {
        $this->relax = $relax;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new QuandlCaching())->refreshCash($this->relax);
    }
}
