<?php

namespace App\Listeners;

use App\Events\MetadataUpdateHasFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Mail\MetadataUpdated;


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
            
        \Mail::to(env('MAIL_ADMIN'))->send(new MetadataUpdated([
                'provider' => $event->provider,
                'database' => $event->database,
                'created' => $event->created,
                'updated' => $event->updated,
                'invalidated' => $event->invalidated
            ]
        ));    
    }
}
