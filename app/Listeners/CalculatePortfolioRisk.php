<?php

namespace App\Listeners;

use App\Events\PortfolioChanged;
use App\Jobs\CalcPortfolioRisk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CalculatePortfolioRisk
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
     * @param  PortfolioChanged  $event
     * @return void
     */
    public function handle(PortfolioChanged $event)
    {
        $event->portfolio->keyFigure('risk')->validUntil($event->timestamp);

        dispatch(new CalcPortfolioRisk($event->portfolio));
    }
}
