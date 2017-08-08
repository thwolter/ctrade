<?php

namespace App\Listeners\Portfolio;

use App\Events\PortfolioRiskWasCalculated;
use App\Jobs\CheckLimits;
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
    public function handle(PortfolioRiskWasCalculated $event)
    {
        dispatch(new CheckLimits($event->portfolio));
    }
}
