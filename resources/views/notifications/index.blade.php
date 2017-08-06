@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

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

                            @include ('notifications.complete.'.snake_case(class_basename($notification->type)))
                            @php $notification->markAsRead() @endphp

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
        </div>
    </div>

@endsection