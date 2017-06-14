<?php

namespace App\Listeners;

use App\Events\MetadataUpdateHasFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;


class NotifyMetadataUpdatedHasFinished
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
        Log::info(sprintf('update finished for provider %s and database %s with %s created, %s updated and %s invalidated',
            $event->provider, $event->database, $event->created, $event->updated, $event->invalidated));
    }
}
