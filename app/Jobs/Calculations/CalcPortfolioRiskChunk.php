<?php

namespace App\Jobs\Calculations;

use App\Facades\RiskService\RiskService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        foreach ($this->object->getChunk() as $date) {

            $this->obtainPortfolioVaR($date);

            foreach ($this->portfolio->assets as $asset) {
                $this->obtainInstrumentVaR($asset, $date);
            }

            $this->object->notifyCompletion($date);
        }
    }

    /**
     * @param $date
     */
    private function obtainPortfolioVaR($date)
    {
        $this->persist('VaR', $date,
            RiskService::portfolioVaR($this->portfolio, $this->portfolio->riskParameter($date))
        );
    }


    /**
     * @param $asset
     * @param $date
     */
    private function obtainInstrumentVaR($asset, $date)
    {
        $this->persist('VaR.' . $asset->label, $date,
            RiskService::instrumentVaR($asset->positionable, $this->portfolio->riskParameter($date))
        );
    }
}
