@extends('layouts.master')

@section('content')

    @include('auth.partials.header')

    <div class="content">
        <div class="container">

            <portlet title="Account angelegt">
                <h2 class="text-center">Fast geschafft</h2>
                <p class="text-center lead">Vielen Dank, dass du dich auf unserer Seite registierte hast. </p>
                <p class="text-center lead">
                    Bitte bestätige deine Email Adresse mit dem Link, dem wir dir per Email geschickt haben.
                </p>
                <p class="text-center">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                </p>
            </portlet>

        </div>
    </div>
@endsection