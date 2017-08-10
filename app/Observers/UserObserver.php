<?php


namespace App\Observers;


use App\Entities\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->email_token = str_random(30);
    }
}