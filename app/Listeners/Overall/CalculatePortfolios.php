<?php

namespace App\Listeners\Overall;

use App\Entities\Portfolio;
use App\Events\MetadataUpdateHasFinished;
use App\Jobs\Calculations\CalcPortfolioRisk;
use App\Jobs\Calculations\CalcPortfolioValue;
use App\Jobs\Calculations\CheckLimits;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CalculatePortfolios implements ShouldQueue
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
        //Todo: check with provided event data on provider and database, which portfolios requires update.
        foreach (Portfolio::all() as $portfolio)
        {
            dispatch(new CalcPortfolioValue($portfolio));
            dispatch(new CalcPortfolioRisk($portfolio));
            dispatch(new CheckLimits($portfolio));
        }
    }
}
