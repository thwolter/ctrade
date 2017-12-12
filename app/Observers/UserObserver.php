<?php


namespace App\Observers;


use App\Entities\User;
use App\Events\Verification\EmailHasChanged;
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
        if ($user->isDirty('email_new') && $user->email_new) {

            $user->email_token = str_random(30);
            $user->email_token_expires_at = Carbon::now()->addDays(7);

            event(new EmailHasChanged($user));
        }
    }
}