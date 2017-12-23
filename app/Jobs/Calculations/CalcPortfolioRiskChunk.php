<?php

namespace App\Jobs\Calculations;

use Carbon\Carbon;
use App\Facades\RscriptService\RscriptService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcPortfolioRiskChunk extends Calculation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->object->getChunk() as $date)
        {
            $this->storeKpis($date, $this->calculateRisk($date));
            $this->object->notifyCompletion($date);
        }
    }


    /**
     * Calculate the risk on the given date.
     *
     * @param Carbon $date
     * @return array
     */
    private function calculateRisk($date)
    {
        $portfolio = $this->object->getPortfolio();

        return RscriptService::portfolioRisk($portfolio, $date->toDateString());
    }


}
