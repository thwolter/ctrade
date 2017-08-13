<notifications
        :user_id="{{ Auth::user()->id }}"
        :unread="{{ json_encode(Auth::user()->unreadNotifications) }}">

</notifications>
