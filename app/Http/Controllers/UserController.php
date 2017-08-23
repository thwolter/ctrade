<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Events\Verification\EmailHasChanged;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\UpdateProfile;
use App\Jobs\Auth\NewEmailVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function edit(Request $request)
    {
        $user = $request->user();

        if (!session('active_tab')) {
            session(['active_tab' => $request->get('tab', 'profile')]);
        }

        return view('users.edit', compact('user'));
    }


    public function update(UpdateProfile $request)
    {
        $message = null;

        $user = $request->user();
        $user->name = $request->get('name');
        $user->save();


        if ($user->email != $request->get('email'))
        {
            $user->email_new = $request->get('email');
            $user->save();

            event(new EmailHasChanged($user));
            $message = "\nBitte bestätige deine neue Email-Adresse über den Link, den wir dir per Email geschickt haben.";
        }

        return redirect()->route('users.edit')
            ->with('message', 'Profil erfolgreich aktualisiert.'.$message)
            ->with('active_tab', $request->get('tab'))
            ->with('email_new', $user->email_new);
    }


    public function password(ChangePassword $request)
    {
        $request->user()
            ->fill(['password' => Hash::make($request->password)])
            ->save();

        return redirect()->route('users.edit')
            ->with('message', 'Passwort erfolgreich geändert')
            ->with('active_tab', 'password');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_token', $token)->verified()->validToken()->first();

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
