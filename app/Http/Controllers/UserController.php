<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'))
            ->with('tab', $request->get('active', 'profile'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->get('name');
        $user->email = $request->get('email');

        $user->save();

        return redirect('users.edit')->with('message', 'User updated.');
    }
}
