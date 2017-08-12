<?php

namespace App\Listeners\Limit;

use App\Events\Limits\LimitHasBreached;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyLimitHasBreached implements ShouldQueue
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
     * @param  LimitHasBreached  $event
     * @return void
     */
    public function handle(LimitHasBreached $event)
    {
        $limit = $event->limit;
        $limit->portfolio->user->notify(new \App\Notifications\LimitBreached($limit));
    }
}
