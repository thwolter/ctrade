<?php

namespace App\Http\Controllers;


use App\Entities\Taker;
use App\Http\Requests\SubscribeRequest;
use App\Jobs\Subscription\SendVerificationEmail;

class TakerController extends Controller
{

    public function subscribe(SubscribeRequest $request)
    {
        $taker = Taker::firstOrCreate(['email' => $request->email]);
        dispatch(new SendVerificationEmail($taker));

        return view('taker.registered');
    }

    public function verify($token)
    {
        $taker = Taker::where('email_token', $token)->unverified()->first();

        if ($taker) {
            $taker->verified = 1;
            $taker->email_token = null;
            $taker->save();
            return view('taker.verified', compact('taker'));

        } else {
            return view('auth.invalid_token');
        }
    }


}
