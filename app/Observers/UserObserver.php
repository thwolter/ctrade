<?php


namespace App\Observers;


use App\Entities\User;
use App\Helpers\UuidHelper;
use Carbon\Carbon;

class UserObserver
{


    public function creating(User $user)
    {
        //$user->uuid = UuidHelper::generateUuid();

        $user->email_token = str_random(30);
        $user->email_token_expires_at = Carbon::now()->addDays(7);
    }


    public function updating(User $user)
    {
        if ($user->email_new) {

            $user->email_token = str_random(30);
            $user->email_token_expires_at = Carbon::now()->addDays(7);
        }
    }

   /* public function saving(User $user)
    {
        // What's that, trying to change the UUID huh?  Nope, not gonna happen.
        $original_uuid = $user->getOriginal('uuid');

        if ($original_uuid !== $user->uuid) {
            $user->uuid = $original_uuid;
        }
    }*/


}