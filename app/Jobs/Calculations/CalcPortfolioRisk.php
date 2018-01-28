<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Jobs\Calculations\CalculateChunks\PortfolioRiskChunk;
use App\Jobs\Calculations\Traits\PeriodTrait;
use App\Jobs\Calculations\Traits\StatusTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class CalcPortfolioRisk
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use PeriodTrait, StatusTrait;


    protected $joblet;
    protected $chunkSize;


    /**
     * Create a new job instance.
     *
     * @param Portfolio $portfolio
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->joblet = new Joblet($portfolio, 'risk');
        $this->chunkSize = config('calculation.chunk.risk');

    }


    public function handle()
    {
        if ($dates = $this->dates($this->joblet)) {

            $this->joblet->setTotal($dates->count());
            $this->remember($this->joblet->id, $dates);

            foreach ($dates->chunk($this->chunkSize) as $chunk) {
                dispatch(new PortfolioRiskChunk($this->joblet, $chunk));
            }
        }
    }
}
