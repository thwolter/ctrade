@extends('layouts.master')

@section('content')

    <section class="g-color-white g-bg-darkgray-radialgradient-circle g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        <strong>Willkommen {{ Auth::user()->email }}</strong>
                    </h2>
                </div>
            </div>
        </div>
    </section>

@endsection