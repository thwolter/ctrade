<?php

namespace App\Jobs\Calculations\CalculateChunks;

use App\Facades\RiskService\RiskService;
use App\Jobs\Calculations\Joblet;
use App\Jobs\Calculations\Traits\PersistTrait;
use App\Jobs\Calculations\Traits\StatusTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PortfolioRiskChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use PersistTrait, StatusTrait;

    private $joblet;
    private $chunk;


    public function __construct(Joblet $joblet, $chunk)
    {
        $this->joblet = $joblet;
        $this->chunk = $chunk;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->chunk as $date) {

            $this->obtainPortfolioVaR($date);
            $this->obtainInstrumentVaRs($date);

            $this->updateStatus($this->joblet, $date);
        }
    }

    /**
     * @param $date
     */
    private function obtainPortfolioVaR($date)
    {
        $portfolio = $this->joblet->portfolio;

        $this->persist($this->joblet, $date,
            RiskService::portfolioVaR($portfolio, $portfolio->riskParameter($date))
        );
    }

    /**
     * @param $date
     */
    private function obtainInstrumentVaRs($date): void
    {
        foreach ($this->joblet->portfolio->assets as $asset) {
            $this->obtainInstrumentVaR($asset, $date);
        }
    }

    /**
     * @param $asset
     * @param $date
     */
    private function obtainInstrumentVaR($asset, $date)
    {
        $portfolio = $this->joblet->portfolio;
        $joblet = $this->joblet;

        $this->persistWithAsset($joblet->setAsset($asset), $date,
            RiskService::instrumentVaR($asset->positionable, $portfolio->riskParameter($date))
        );
    }
}
