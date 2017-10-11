@extends('layouts.master')

@section('content')

    <div class="g-brd-bottom g-brd-gray-light-v4"></div>

    <!-- Promo Block -->
    <section class="container g-py-150">
        <div class="row">
            <div class="col-lg-12">

                <h2 class="h3 u-heading-v2__title text-uppercase g-font-weight-300">
                    Passwort erfolgreich geändert.
                </h2>
                <p class="lead g-mb-20">
                    Dein Passwort wurde erfolgreich geändert.
                </p>

                <a href="{{ route('portfolios.index') }}" class="btn btn-primary g-mt-20">
                    Zu meinen Portfolios
                </a>

            </div>
        </div>
    </section>

    <div class="container g-py-30"></div>

@endsection