<?php


namespace App\Repositories;


use App\Classes\Helpers;
use App\Entities\Portfolio;
use Carbon\Carbon;

class RiskRepository
{

    protected $portfolio;

    protected $daysPerYear = 250;


    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }


    public function portfolioRisk($conf, $period, $date = null)
    {
        $risks = $this->portfolio->keyFigure('risk')->values;
        $referenceDate = Carbon::parse(key($risks));
        $dailyRisk = array_get(head($risks), $conf);

        if (is_null($date)) {
            $factor = sqrt($period);

        } else {
            $factor = sqrt(max(0, $referenceDate->diffInDays($date, false)));
        }

        return $dailyRisk * $factor;
    }
}