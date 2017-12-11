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
        setActiveTab($request, 'profile');

        return view('users.edit', compact('user'));
    }


    public function update(UpdateProfile $request)
    {
        $message = null;
        $user = $request->user();

        $user->update([
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName')
        ]);

        if ($user->email != $request->get('email_new'))
        {
            $user->update(['email_new' => $request->get('email_new')]);
            event(new EmailHasChanged($user));
        }

        return redirect()->route('users.edit')
            ->with('status', 'success')
            ->with('active_tab', $request->get('tab'));
    }


    public function password(ChangePassword $request)
    {
        $request->user()
            ->fill(['password' => Hash::make($request->password)])
            ->save();

        return redirect()->route('users.edit')
            ->with('success', 'Passwort erfolgreich geändert')
            ->with('active_tab', $request->get('active_tab'));
    }


    public function emailLink()
    {
        event(new EmailHasChanged(\Auth::user()));

        return redirect()->back();
    }

    public function emailCancel()
    {
        \Auth::user()->update(['email_new' => null]);

        return redirect()->back();
    }
}
