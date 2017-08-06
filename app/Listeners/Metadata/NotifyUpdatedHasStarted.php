<?php

namespace App\Listeners\Metadata;

use App\Events\MetadataUpdateHasStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyUpdatedHasStarted implements ShouldQueue
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
     * @param  MetadataUpdateHasStarted  $event
     * @return void
     */
    public function handle(MetadataUpdateHasStarted $event)
    {
        Log::info(sprintf('update started for provider %s and database %s',
            $event->provider, $event->database));
    }
}
