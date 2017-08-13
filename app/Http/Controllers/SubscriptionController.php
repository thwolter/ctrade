<?php

namespace App\Http\Controllers;


use App\Entities\User;
use App\Http\Requests\SubscribeRequest;
use App\Jobs\Subscription\SendVerificationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function subscribe(SubscribeRequest $request)
    {
        $user = User::firstOrCreate(['email' => $request->email, 'name' => '']);
        $user->assignRole('taker');

        dispatch(new SendVerificationEmail($user));

        return view('subscription.registered');
    }

    public function verify($token)
    {
        $user = User::where('email_token', $token)->unverified()->first();

        if ($user) {
            $user->verified = 1;
            $user->email_token = null;
            $user->save();
            return view('subscription.verified', compact('user'));

        } else {
            return view('auth.invalid_token');
        }
    }


}
