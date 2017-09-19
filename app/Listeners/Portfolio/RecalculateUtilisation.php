<?php

namespace App\Listeners\Portfolio;

use App\Events\PortfolioWasCalculated;
use App\Jobs\Calculations\CheckLimits;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecalculateUtilisation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PortfolioRiskWasCalculated  $event
     * @return void
     */
    public function handle(PortfolioWasCalculated $event)
    {
        dispatch(new CheckLimits($event->portfolio));
    }
}
