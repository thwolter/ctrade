@extends('layouts.master')

@section('content')

    <section class="portfolio">

        <nav class="portfolio--nav">
            <ul>
                <li class="{{ active_class(if_route_pattern(['portfolios.*'])) }}">
                    <a href="{{ route('portfolios.show', $portfolio->id) }}">Überblick</a></li>

                <li class="{{ active_class(if_route_pattern(['positions.*'])) }}">
                    <a href="{{ route('positions.index', $portfolio->id) }}">Positionen</a></li>

                <li>
                    <a href="#">Marktwerte</a></li>

                <li class="{{ active_class(if_route_pattern(['risks.*'])) }}">
                    <a href="{{ route('risks.index', $portfolio->id) }}">Risiko</a></li>

                <li><a href="#">Optimieren</a></li>
            </ul>
        </nav>

        <main class="portfolio--body">
            @yield('container-content')
        </main>

        <!-- footer -->
        <footer></footer>



    </section>

@endsection



