<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Events\Limits\LimitHasBreached;
use App\Facades\MetricService\LimitMetricService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckLimits implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $portfolio;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->portfolio->limits as $limit)
        {
            if (LimitMetricService::breached($limit)) {
                event(new LimitHasBreached($limit));
            }
        }
    }
}
