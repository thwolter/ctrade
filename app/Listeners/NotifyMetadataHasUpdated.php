<?php

namespace App\Listeners;

use App\Events\MetadataHasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMetadataHasUpdated
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
     * @param  MetadataHasUpdated  $event
     * @return void
     */
    public function handle(MetadataHasUpdated $event)
    {
        //
    }
}
