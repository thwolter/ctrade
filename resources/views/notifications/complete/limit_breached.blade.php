@php
    \Carbon\Carbon::setLocale('de');
    $ago = \Carbon\Carbon::parse($notification->data['updated_at'])->diffForHumans(\Carbon\Carbon::now());
@endphp


<tr>
    <td><i class="fa fa-cloud-upload text-primary"></i></td>
    <td>{{ $notification->data['title'] }}</td>
    <td>{{ $notification->data['message'] }}</td>
    <td>{{ $ago }}</td>
</tr>
