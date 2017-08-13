<li class="dropdown navbar-notification">

    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
        <i class="fa fa-bell navbar-notification-icon"></i>
        <span class="visible-xs-inline">&nbsp;Notifications</span>
        @php
            $count = count(Auth::user()->unreadNotifications)
        @endphp
        @if ($count)
            <b class="badge badge-primary">{{ $count }}</b>
        @endif
    </a>

    <div class="dropdown-menu">
        <div class="dropdown-header">&nbsp;Notifications</div>
        <div class="notification-list">

            @foreach(Auth::user()->unreadNotifications as $notification)

                @include ('notifications.unread.'.snake_case(class_basename($notification->type)))
                @php $notification->markAsRead() @endphp

            @endforeach

        </div>

        <a href="{{ route('notifications.index') }}" class="notification-link">Alle
            Benachichtigungen</a>

    </div>
</li>