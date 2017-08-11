@extends('layouts.master')

@section('content')

    @include('auth.partials.header')

    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <portlet title="Neue Email Adresse">
                        <p class="text-center lead">
                            Deine neue Email {{ $user->email }} wurde erfolgreich bestätigt.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-default">Login</a>
                    </portlet>
                </div>
            </div>
        </div>
    </div>

@endsection
