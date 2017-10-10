@extends('layouts.master')

@section('content')

    <section class="g-color-white g-bg-primary g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        <strong>Herzlich Willkommen</strong>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <section class="g-py-200--md g-py-80">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-8 ml-md-auto mr-md-auto">
                    <h3 class="g-font-size-12 text-uppercase g-font-weight-600 g-mb-15">
                        <span class="g-color-primary">Herzlich</span>
                        Willkommen
                    </h3>
                    <h2 class="h1 text-uppercase g-mb-25"> Du bist erfolgreich angemeldet</h2>

                    <p class="lead g-mb-60">
                        Du kannst sofort loslegen und dein erstes Portfolio erstellen.
                        Bitte vergiss nicht, deine Email-Adresse zu bestätigen. Den Link dazu haben wir dir an deine
                        Email-Adresse geschickt.
                    </p>

                    <a href="{{ route('portfolios.create') }}" class="btn btn-md u-btn-bluegray g-mr-10 g-mb-15">
                        Portfolio erstellen
                    </a>

                </div>
            </div>
        </div>
    </section>

@endsection