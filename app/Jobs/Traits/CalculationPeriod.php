<?php

namespace App\Jobs\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

trait CalculationPeriod
{

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function daysToCompute($type)
    {
        Log::info("Check key figure {$type} on portfolio {$this->portfolio->id} ...");
        $startDate = $this->startDate($type);

        if ($startDate) {
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($startDate, $interval, Carbon::now()->endOfDay());

            Log::info("Start calculation with date {$startDate} ...");
            return collect($period);

        } else {
            Log::info('Nothing to calculate; all values up-to-date');
            return null;
        }
    }

    /**
     * @return Carbon
     */
    protected function startDate($type)
    {
        $keyFigureDate = $this->portfolio->keyFigure($type)->date;

        return $keyFigureDate
           ? optional($this->portfolio->firstTransactionEnteredAfter($keyFigureDate))->executed_at
           : $this->portfolio->created_at;
    }
}