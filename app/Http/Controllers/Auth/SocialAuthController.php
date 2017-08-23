<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @return Response
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->scopes(['email'])->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return Response
     */
    public function callback($provider, UserRepository $repo)
    {
        $user = $repo->createOrGetUser(Socialite::driver($provider)->user(), $provider);

        Auth::login($user, true);
        return redirect(route('home'))
            ->with('message', 'Wir haben Deinen Account verknüpft');
    }
}
