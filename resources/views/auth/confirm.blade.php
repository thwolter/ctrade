@extends('layouts.master')

@section('content')

    @include('auth.partials.header')

    <div class="container" style="height: 100vH">
        <div class="space-70"></div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="panel panel-default">
                    <h2 class="text-center">Geschafft!</h2>
                    <p class="text-center">
                        Deine Email wurde erfolgreich bestätigt. Klicke hier, um dich einzuloggen <a href="{{ route('login') }}">login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
