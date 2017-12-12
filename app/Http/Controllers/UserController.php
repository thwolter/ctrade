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
        $active_tab = $request->old('active_tab', session('active_tab', 'profile'));

        return view('users.edit', compact('user', 'active_tab'));
    }


    public function update(UpdateProfile $request)
    {
        $request->user()->update($request->only(['first_name', 'last_name', 'email_new']));

        return redirect()->route('users.edit')
            ->with('status', 'profile_updated')
            ->with('active_tab', $request->get('active_tab'));
    }


    public function password(ChangePassword $request)
    {
        $request->user()
            ->fill(['password' => Hash::make($request->password)])
            ->save();

        return redirect()->route('users.edit')
            ->with('status', 'password_changed')
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
