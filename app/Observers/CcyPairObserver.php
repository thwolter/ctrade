<?php


namespace App\Observers;


use App\Entities\CcyPair;
use Illuminate\Support\Facades\Log;


class CcyPairObserver
{

    public function created(CcyPair $ccyPair)
    {
        Log::notice(sprintf('Create ccy pair %s/%s.', $ccyPair->origin, $ccyPair->target));
    }

}