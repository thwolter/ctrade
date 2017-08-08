<?php

namespace App\Listeners\Metadata;

use App\Events\MetadataUpdateHasFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Mail\MetadataUpdated;
use App\Entities\Provider;
use App\Entities\Database;
use App\Facades\Datasource;


class NotifyUpdatedHasFinished implements ShouldQueue
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
            $event->provider, $event->database));
        

    }
}
