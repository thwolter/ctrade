<?php

namespace App\Listeners;

use App\Events\MetadataUpdateHasFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FindInvalideMetadata
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
        //
    }
}
