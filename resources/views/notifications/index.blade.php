@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Benachrichtigungen</h3>
    </div>

    <div class="portlet portlet-boxed">
        <div class="portlet-body">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif


            <table class="table table-responsive table-striped">
                @foreach($notifications as $notification)

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
                @endforeach
            </table>

            @if (count($notifications))
                {!! Form::open(['route' => ['notifications.delete'], 'method' => 'DELETE',
                    'class' => 'form form-horizontal']) !!}

                <div class="">
                    {!! Form::submit('Benachichtigungen löschen', ['class' => 'btn btn-primary']) !!}
                </div>
            @endif

            @if(!count($notifications) and !session('message'))
                <div class="alert alert-info">
                    Keine Benachichtigungen vorhanden.
                </div>
            @endif

            {!! Form::close() !!}

        </div>
    </div>

@endsection