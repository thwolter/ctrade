<?php

namespace App\Listeners\PriceData;

use App\Events\PriceData\FetchingFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFetchingFailed
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
     * @param  FetchingFailed  $event
     * @return void
     */
    public function handle(FetchingFailed $event)
    {
        //
    }
}
