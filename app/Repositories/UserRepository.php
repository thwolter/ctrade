<?php

namespace App\Repositories;


use App\Entities\SocialAccount;
use App\Entities\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class UserRepository
{

    public function getUser(ProviderUser $providerUser, $provider)
    {
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        return ($account) ? $account->user : null;
    }


    public function createUser(ProviderUser $providerUser, $provider)
    {
        $account = new SocialAccount([
            'provider_user_id' => $providerUser->getId(),
            'provider' => $provider
        ]);

        $user = User::whereEmail($providerUser->getEmail())->first();

        if (!$user) {

            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'avatar' => $providerUser->getAvatar(),
                'verified' => 1
            ]);
        }

        $account->user()->associate($user);
        $account->save();

        return $user;
    }
}
