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
     * Call the rscript for risk calculation for each date between last calculation and today.
     * If no calculations are done yet, take the date of portfolio creation as the first date.
     * To ensure that the portfolio at the due date is taken as a basis, the portfolio trades
     * conducted after the due date have to be rewind for calculation purposes.
     *
     * @return void
     */
    public function handle()
    {
        $kfRisk = $this->portfolio->keyFigure('risk');
        $kfContrib = $this->portfolio->keyFigure('contribution');

        // perhaps it is sufficient to check only one keyFigure
        $start = $kfRisk->calculateFromDate();
        $today = Carbon::now()->endOfDay();

        for ($date = clone $start; $date->diffInDays($today, false) >= 0; $date->addDay()) {

            $portfolio = $this->portfolio->rollbackToDate($date);

            $rscript = new Rscript($portfolio);
            $risk = $rscript->portfolioRisk($date->toDateString(), 250);

            $kfRisk->set($date->toDateString(), $this->toRiskArray($risk));
            $kfContrib->set($date->toDateString(), $this->toContribArray($risk));
        }

        $kfRisk->validUntil($today->startOfDay());
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
            '0.95' => array_first_or_null($risk['total95']),
            '0.975' => array_first_or_null($risk['total975']),
            '0.99' => array_first_or_null($risk['total99'])
        ];
    }


    /**
     * Returns a formatted array with risk contributions for required confidence levels.
     *
     * @param $risk
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
}
