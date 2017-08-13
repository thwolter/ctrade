<?php

namespace App\Listeners\Overall;

use App\Entities\Portfolio;
use App\Events\MetadataUpdateHasFinished;
use App\Jobs\CalcPortfolioRisk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRiskCalculations implements ShouldQueue
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
     * @param  MetadataUpdateHasFinished  $event
     * @return void
     */
    public function handle(MetadataUpdateHasFinished $event)
    {
        foreach (Portfolio::all() as $portfolio)
        {
            dispatch(new CalcPortfolioRisk($portfolio));
        }
    }
}
