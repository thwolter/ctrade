<?php


namespace App\Repositories;


use App\Classes\Helpers;
use App\Entities\Portfolio;
use Carbon\Carbon;

class RiskRepository
{

    protected $portfolio;

    protected $daysPerYear = 250;
    protected $referenceDate;


    public function __construct(Portfolio $portfolio, Carbon $referenceDate = null)
    {
        $this->portfolio = $portfolio;
        $this->referenceDate = $referenceDate;
    }


    public function portfolioRisk($conf, $period, $date = null)
    {
        $risks = $this->portfolio->keyFigure('risk')->values;
        $dailyRisk = array_get(head($risks), $conf);

        if (is_null($date)) {
            $factor = sqrt($period);

        } else {
            $factor = sqrt(max(0, $this->referenceDate->diffInDays($date, false)));
        }

        return $dailyRisk * $factor;
    }
}