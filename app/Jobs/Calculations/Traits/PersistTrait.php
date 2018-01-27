<?php

namespace App\Jobs\Calculations\Traits;


use App\Facades\Repositories\KeyfigureRepository;
use Illuminate\Support\Carbon;

trait PersistTrait
{
    /**
     * Persist a keyfigure.
     *
     * @param $joblet
     * @param Carbon $date
     * @param $value
     */
    protected function persist($joblet, $date, $value)
    {
        KeyfigureRepository::find($joblet->portfolio, $joblet->metric)
            ->setCalculatedAt($joblet->calculated_at)
            ->set($date->toDateString(), $value->getValue());
    }
}