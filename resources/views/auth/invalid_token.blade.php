@extends('layouts.master')

@section('content')

    <!-- Promo Block -->
    <section class="container g-py-150 g-brd-bottom g-brd-gray-light-v4 g-bg-gray-light-v5">
        <div class="row">
            <div class="col-lg-12">

                <h2 class="h3 u-heading-v2__title text-uppercase g-font-weight-300">
                    Sorry, der Token ist ungültig
                </h2>
                <p class="lead g-mb-20">
                    Der von dir verwendete Token zur Bestätigung deiner Email-Adresse ist ungültig.
                    Bitte verwende eine bestätigte Email-Adresse zur Anmeldung. Falls du dein Passwort
                    vergessen hast, kannst du es mit folgendem Link widerherstellen.
                </p>

                <a href="{{ route('password.request') }}" class="btn btn-outline-secondary">
                    Passwort vergessen?
                </a>

            </div>
        </div>
    </section>

    <div class="container g-py-30"></div>

@endsection