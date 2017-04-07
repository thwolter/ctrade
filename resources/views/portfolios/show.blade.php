@extends('layouts.master')

@section('content')

    <section class="portfolio-panel">

        @include('portfolios.header')

        <!-- sidebar navigation -->
        <div class="portfolio-panel__portfolio-nav">
            <nav class="portfolio-nav">
                <ul>
                    <li><a href="#">Überblick</a></li>
                    <li><a href="#">Transaktionen</a></li>
                    <li><a href="#">Marktwerte</a></li>
                    <li><a href="#">Risiko</a></li>
                    <li><a href="#">Optimieren</a></li>
                </ul>
            </nav>
        </div>

        <!--content-portfolio -->
        <main class="portfolio-panel__portfolio-body">

            @yield('portfolio-container-content')

        </main>

        <!-- footer -->
        <footer></footer>

    </section>



@endsection



