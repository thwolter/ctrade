<?php

namespace App\Http\Controllers\Api;

use App\Entities\User;
use Illuminate\Http\Request;

class ApiNotificationsController extends ApiBaseController
{
    public function markAsRead(Request $request){

        foreach (User::find($request->id)->unreadNotifications as $notification)
        {
            $notification->markAsRead();
        }
    }
}
