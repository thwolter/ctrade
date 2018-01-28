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
            ->set($date->toDateString(), $value);
    }


    /**
     * Persist a keyfigure with an associated instrument.
     *
     * @param $joblet
     * @param $date
     * @param $value
     */
    protected function persistWithAsset($joblet, $date, $value)
    {
        KeyfigureRepository::findWithAsset($joblet->asset, $joblet->metric)
            ->setCalculatedAt($joblet->calculated_at)
            ->set($date->toDateString(), $value);
    }
}