<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Jobs\Traits\CalculationPeriod;
use App\Models\Rscript;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\TradesRepository;

class CalcPortfolioValue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use CalculationPeriod;

    protected $portfolio;

    /**
     * Create a new job instance.
     *
     * @param Portfolio $portfolio
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
        foreach ($this->period()->chunk(config('calculation.chunk.value')) as $dates)
        {
            dispatch(new CalcPortfolioValueChunk($this->portfolio, $dates));
        }
    }
}
