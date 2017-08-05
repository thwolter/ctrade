@php
    \Carbon\Carbon::setLocale('de');
    $ago = \Carbon\Carbon::parse($notification->data['updated_at'])->diffForHumans(\Carbon\Carbon::now());
@endphp

<a href="./page-notifications.html" class="notification">
    <span class="notification-icon"><i class="fa fa-cloud-upload text-primary"></i></span>
    <span class="notification-title">{{ $notification->data['title'] }}</span>
    <span class="notification-description">{{ $notification->data['message'] }}</span>
    <span class="notification-time">{{ $ago }}</span>
</a> <!-- / .notification -->