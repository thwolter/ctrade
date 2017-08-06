<?php

namespace App\Listeners\Limit;

use App\Events\LimitHasChanged;
use App\Notifications\LimitChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyLimitHasChanged implements ShouldQueue
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
     * @param  LimitHasChanged  $event
     * @return void
     */
    public function handle(LimitHasChanged $event)
    {
        $limit = $event->limit;
        $limit->portfolio->user->notify(new LimitChanged($limit));
    }
}
