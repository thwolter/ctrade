<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\UpdateProfile;
use App\Jobs\Auth\NewEmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function verifyEmail($token)
    {
        $user = User::where('email_token', $token)->verified()->first();

        if ($user) {
            $user->email = $user->email_new;
            $user->email_new = null;
            $user->email_token = null;
            $user->save();

            return view('auth.confirmed.email', compact('user'));

        } else {
            return view('auth.invalid_token');
        }
    }
}
