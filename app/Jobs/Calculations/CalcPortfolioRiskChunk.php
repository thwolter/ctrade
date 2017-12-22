<?php

namespace App\Jobs\Calculations;

use App\Facades\KeyfigureRepository;
use App\Models\Rscript;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcPortfolioRiskChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $object;


    /**
     * Create a new job instance.
     *
     * @param CalculationObject $object
     */
    public function __construct(CalculationObject $object)
    {
        $this->object = $object;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->object->getChunk() as $date)
        {
            $key = $date->toDateString();
            $risk = $this->calculateRisk($date);

            $this->storeRiskKpis($key, $risk);
            $this->storeContributionKpi($key, $risk);

            $this->object->notifyCompletion($date);
        }
    }


    /**
     * Calculate the risk on the given date.
     *
     * @return array
     */
    private function calculateRisk($date)
    {
        $rscript = new Rscript($this->object->getPortfolio());
        return $rscript->portfolioRisk($date->toDateString(), config('calculation.risk.period'));
    }


    /**
     * @param $key
     * @param $risk
     */
    private function storeRiskKpis($key, $risk): void
    {
        $this->storeKpi('risk.95', $key, array_first_or_null($risk['total95']));
        $this->storeKpi('risk.975', $key, array_first_or_null($risk['total975']));
        $this->storeKpi('risk.99', $key, array_first_or_null($risk['total99']));
    }

    /**
     * @param $key
     * @param $risk
     */
    private function storeContributionKpi($key, $risk): void
    {
        $this->storeKpi('contribution.95', $key, $risk['contrib95']);
        $this->storeKpi('contribution.975', $key, $risk['contrib975']);
        $this->storeKpi('contribution.99', $key, $risk['contrib99']);
    }


    /**
     * @param $kpiName
     * @param $key
     * @param $value
     */
    private function storeKpi($kpiName, $key, $value)
    {
        $keyfigure = KeyfigureRepository::getForPortfolio($this->object->getPortfolio(), $kpiName);
        $keyfigure->effective_at = $this->object->getEffectiveAt();
        $keyfigure->set($key, $value);


    }
}
