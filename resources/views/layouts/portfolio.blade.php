@extends('layouts.master')

@section('content')

    <section class="portfolio-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2>{{ $portfolio->name }}</h2>
                </div>
                <div class="col-md-2">
                    <h2 class="key-figures">
                        <span class="key-desc">Wert</span><span>{{ $portfolio->present()->total() }}</span>
                        <span class="key-desc">Risiko</span><span>200</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>


                    @yield('container-content')



    <div class="space-70"></div>
@endsection


