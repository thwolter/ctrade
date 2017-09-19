<?php

namespace App\Listeners\Portfolio;

use App\Events\PortfolioHasChanged;
use App\Jobs\Calculations\CalcPortfolioRisk;
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
        dispatch(new CalcPortfolioRisk($event->portfolio));
    }

}
