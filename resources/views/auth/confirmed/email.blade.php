@extends('layouts.master')

@section('content')

    <!-- Promo Block -->
    <section class="container g-py-150 g-brd-bottom g-brd-gray-light-v4 g-bg-gray-light-v5">
        <div class="row">
            <div class="col-lg-12">

                <h2 class="h3 u-heading-v2__title text-uppercase g-font-weight-300">
                    Email erfolgreich geändert
                </h2>
                <p class="lead g-mb-20">
                    Du hast deine neue Email <strong>{{ $user->email }}</strong> erfolgreich bestätigt.
                    Bitte nutze künftig deine neue Email Adresse, um dich einzuloggen.
                </p>

                @guest
                    <a href="{{ route('login') }}" class="btn btn-success">
                        Weiter zum Login</a>
                @endguest

                @auth
                    <a href="{{ route('home') }}" class="btn btn-success">
                        Zu meinen Portfolios</a>
                @endauth

            </div>
        </div>
    </section>

    <div class="container g-py-10"></div>

@endsection
