@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <portlet title="Neue Email Adresse">
                        <p class="text-center">
                            Deine neue Email {{ $user->email }} wurde erfolgreich bestätigt.
                        </p>

                        @if (Auth::guest())
                            <p class="text-center">
                                <a href="{{ route('login') }}" class="btn btn-link">
                                    Weiter zum Login</a>
                            </p>
                        @else
                            <p class="text-center">
                                <a href="{{ route('home') }}" class="btn btn-link">
                                    zu meinen Portfolios</a>
                            </p>
                        @endif

                    </portlet>
                </div>
            </div>
        </div>
    </div>

@endsection
