<?php

namespace App\Jobs\Calculations\Traits;


use App\Facades\PortfolioService;
use App\Facades\Repositories\KeyfigureRepository;
use Carbon\Carbon;

trait PeriodTrait
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected function dates($joblet)
    {
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($this->startDate($joblet), $interval, Carbon::now()->endOfDay());

        return collect($period);
    }


    protected function startDate($joblet)
    {
        list($effectiveAt, $calculatedAt) = $this->keyfigureDates($joblet);
        $executedAt = PortfolioService::nextExecutedAt($this->joblet->portfolio, $effectiveAt);

        return max(
            $this->firstDate([$effectiveAt, $calculatedAt, $executedAt]),
            $this->joblet->portfolio->opened_at
        );
    }


    protected function keyfigureDates($joblet)
    {
        $keyfigure = KeyfigureRepository::getByPortfolio($joblet->portfolio, $joblet->metric);
        return [$keyfigure->calculated_at, $keyfigure->date];
    }

    /**
     * @param array $dates
     * @return mixed|null
     */
    protected function firstDate($dates)
    {
        $dates = array_filter($dates, function ($v) {
            return !is_null($v);
        });

        return $dates ? min($dates) : [];
    }
}