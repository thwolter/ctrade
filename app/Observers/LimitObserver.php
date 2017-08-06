<?php


namespace App\Observers;


use App\Entities\Limit;
use App\Jobs\CheckLimits;
use App\Notifications\LimitChanged;

class LimitObserver
{

    public function updated(Limit $limit)
    {
        event(new \App\Events\LimitHasChanged($limit));
    }
}