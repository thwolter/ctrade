<?php

namespace App\Listeners\Metadata;

use App\Events\MetadataUpdateHasCanceled;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class NotifyUpdatedHasCanceled implements ShouldQueue
{

    protected $delay = 10;


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
        $job = resolve("Update{$event->provider}/{$event->database}")
            ->delay(Carbon::now()->addMinutes($this->delay));

        Log::info("Retry Update for {$event->provider}/{$event->database} in {$this->delay} minutes.");
        dispatch($job);
    }
}
