<?php

namespace App\Listeners\Limit;

use App\Events\LimitHasChanged;
use App\Jobs\CheckLimits;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CheckLimit
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
     * @param  LimitHasChanged  $event
     * @return void
     */
    public function handle(LimitHasChanged $event)
    {
        dispatch(new CheckLimits($event->limit->portfolio));
    }
}
