<?php

namespace App\Listeners\Metadata;

use App\Events\MetadataUpdateHasCanceled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotifyUpdatedHasCanceled implements ShouldQueue
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
     * @param  MetadataUpdateHasCanceled  $event
     * @return void
     */
    public function handle(MetadataUpdateHasCanceled $event)
    {

    }
}
