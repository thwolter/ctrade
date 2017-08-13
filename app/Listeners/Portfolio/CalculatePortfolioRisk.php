<?php

namespace App\Listeners\Portfolio;

use App\Events\PortfolioHasChanged;
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
     * @param  PortfolioHasChanged  $event
     * @return void
     */
    public function handle(PortfolioHasChanged $event)
    {
        $event->portfolio->keyFigure('risk')->validUntil($event->timestamp);

        dispatch(new CalcPortfolioRisk($event->portfolio));
    }

}
