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


    public function verifyEmail($token)
    {
        $user = User::where('email_token', $token)->verified()->first();

        if ($user) {
            $user->update([
                'email' => $user->email_new,
                'email_new' => null,
                'email_token' => null
            ]);

            return view('auth.confirmed.email', compact('user'));
        }

        return view('auth.invalid_token');
    }
}
