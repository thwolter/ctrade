<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Requests\ChangePassword;
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
        session(['active_tab' => $request->get('tab', 'profile')]);

        return view('users.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $request->user()->update([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);

        return redirect('users.edit')
            ->with('message', 'Profil erfolgreich aktualisiert.')
            ->with('active_tab', $request->get('tab'));
    }


    public function password(ChangePassword $request)
    {
        $request->user()->fill([
            'password' => Hash::make($request->newPassword)
        ])->save();

        return redirect()->route('users.edit', $request->user()->id)
            ->with('message', 'Passwort erfolgreich geändert')
            ->with('active_tab', 'password');
    }
}
