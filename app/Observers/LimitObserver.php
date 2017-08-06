<?php


namespace App\Observers;


use App\Entities\Limit;
use App\Jobs\CheckLimits;
use App\Notifications\LimitChanged;

class LimitObserver
{

    public function updated(Limit $limit)
    {
        $limit->portfolio->user->notify(new LimitChanged($limit));
        dispatch(new CheckLimits($limit->portfolio));
    }
}