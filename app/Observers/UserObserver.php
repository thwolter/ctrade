<?php


namespace App\Observers;


use App\Entities\User;
use Carbon\Carbon;

class UserObserver
{

    public function creating(User $user)
    {
        $user->email_token = str_random(30);
        $user->token_expires_at = Carbon::now()->addDays(7);
    }


    public function updating(User $user)
    {
        if ($user->email_new) {

            $user->email_token = str_random(30);
            $user->token_expires_at = Carbon::now()->addDays(7);
        }
    }
}