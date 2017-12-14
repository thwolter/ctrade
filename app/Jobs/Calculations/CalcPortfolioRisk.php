<?php

namespace App\Jobs\Calculations;

use App\Entities\Portfolio;
use App\Jobs\Traits\CalculationPeriod;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Calculate the risk and risk distribution for a given portfolio based on the composition
 * at the time of calculation. It is expected to be started after change of the portfolio
 * and on a regular basis to build a time series of risk.
 *
 * To ensure a calculation based on daily period, a retrograde calculation is required if the
 * portfolio has changed after the due date (e.g. at midnight).
 *
 * @package App\Jobs
 */
class CalcPortfolioRisk
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Call the rscript for risk calculation for each date between last calculation and today.
     *
     * @return void
     */
    public function handle()
    {
        $object = new CalculationObject($this->portfolio, 'risk.95');

        if ($object->hasDates()) {

            foreach ($object->getDates()->chunk(config('calculation.chunk.risk')) as $dates)
            {
                $object->setChunk($dates);
                dispatch(new CalcPortfolioRiskChunk($object));
            }
        }
    }
}
