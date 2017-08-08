<?php

namespace App\Listeners\Metadata;

use App\Entities\User;
use App\Events\MetadataUpdateHasFinished;
use App\Notifications\MetadataUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;



class NotifyUpdatedHasFinished //implements ShouldQueue
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
        Log::info(sprintf('update finished for provider %s and database %s',
            $event->provider, $event->database));

        User::whereEmail('thwolter@gmail.com')->first()
            ->notify(new MetadataUpdated($event->provider, $event->database, $event->started_at));
        

    }
}
