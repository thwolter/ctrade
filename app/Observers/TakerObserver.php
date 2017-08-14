<?php


namespace App\Observers;


use App\Entities\Taker;
use Carbon\Carbon;

class TakerObserver
{

    public function creating(Taker $taker)
    {
        $taker->email_token = str_random(30);
        $taker->email_token_expires_at = Carbon::now()->addDays(7);
    }

}