<?php

namespace App\Jobs;

use App\Entities\Keyfigure;
use App\Entities\Portfolio;
use App\Models\Rscript;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcPortfolioRisk implements ShouldQueue
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $kfRisk = $this->keyFigureRisk();
        $kfContrib = $this->keyFigureContribution();

        $start = $this->startDate($kfRisk); // it is sufficient to check only one keyFigure
        $today = Carbon::now()->endOfDay();

        for ($date = clone $start; $date->diffInDays($today) > 0; $date->addDay()) {

            $rscript = new Rscript($this->portfolio);
            $risk = $rscript->portfolioRisk(0.95, $date->toDateString(), 250);

            $kfRisk->set($date->toDateString(), $this->toRiskArray($risk));
            $kfContrib->set($date->toDateString(), $this->toContribArray($risk));
        }
    }

    /**
     * Return the start date for calculations as the latest date of already calculated values.
     *
     * @param KeyFigure
     * @return Carbon
     */
    private function startDate($keyFigure)
    {
        $date = $this->portfolio->created_at;

        if (count($keyFigure->values) > 0) {
            $date = Carbon::parse(max(max(array_keys($keyFigure->values)), $date))->addDay();

            $invalidated = $keyFigure->invalidated_at;
            if (!is_null($invalidated)) {
                $date = Carbon::parse(min($date, $invalidated));
            }
        }
        return $date->endOfDay();
    }


    /**
     * Returns a formatted array with risk figures per confidence level.
     *
     * @param $risk
     * @return array
     */
    private function toRiskArray($risk)
    {
        return [
            '95' => array_first($risk['total95']),
            '97' => array_first($risk['total97']),
            '99' => array_first($risk['total99'])
        ];
    }


    /**
     * Returns a formatted array with risk contributions for required confidence levels.
     *
     * @param $risk
     * @param $conf
     * @return mixed
     */
    private function toContribArray($risk)
    {
        return [
            '95' => $risk['contrib95'],
            '97' => $risk['contrib97'],
            '99' => $risk['contrib99']
        ];
    }


    /**
     * Find/create and returns the keyFigures for risk time series.
     *
     * @return Keyfigure
     */
    private function keyFigureRisk()
    {
        $keyFigure = $this->portfolio->keyFigure('risk');

        if (is_null($keyFigure)) {
            $keyFigure = $this->portfolio->createKeyFigure('risk', 'Value at Risk');
        }
        return $keyFigure;
    }


    /**
     * Find/create and returns the keyFigures for risk contribution.
     *
     * @return Keyfigure
     */
    private function keyFigureContribution()
    {
        $keyFigure = $this->portfolio->keyFigure('contribution');

        if (is_null($keyFigure)) {
            $keyFigure = $this->portfolio->createKeyFigure('contribution', 'Risk contribution');
        }
        return $keyFigure;
    }
}
