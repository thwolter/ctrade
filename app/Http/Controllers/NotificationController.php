<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('notifications.index', compact('notifications'));
    }

    public function delete()
    {
        Auth::user()->notifications()->delete();

        return redirect(route('notifications.index'))
            ->with('message', 'Benachichtigungen gelöscht.');

    }
}
