<?php

namespace App\Jobs\Calculations;

use App\Events\PortfolioWasCalculated;
use App\Models\Rscript;
use App\Notifications\StatusCalculation;
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
     * @return void
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
        $kpiContrib = $this->object->getPortfolio()->keyFigure('contribution');
        $kpiContrib->effective_at = $this->object->getEffectiveAt();

        foreach ($this->object->getChunk() as $date)
        {
            $key = $date->toDateString();
            $risk = $this->calculateRisk($date);

            $this->object->set($key, $this->toRiskArray($risk));
            $kpiContrib->set($key, $this->toContribArray($risk));

            $this->object->notifyCompletion($date);
        }
    }

    /**
     * Returns a formatted array with risk figures per confidence level.
     *
     * @param array $risk
     * @return array
     */
    private function toRiskArray($risk)
    {
        return [
            '0.95' => array_first_or_null($risk['total95']),
            '0.975' => array_first_or_null($risk['total975']),
            '0.99' => array_first_or_null($risk['total99'])
        ];
    }


    /**
     * Returns a formatted array with risk contributions for required confidence levels.
     *
     * @param array $risk
     * @return mixed
     */
    private function toContribArray($risk)
    {
        return [
            '0.95' => $risk['contrib95'],
            '0.975' => $risk['contrib975'],
            '0.99' => $risk['contrib99']
        ];
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

}
