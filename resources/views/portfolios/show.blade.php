@extends('layouts.master')

@section('content')

    <section class="portfolio-container">

        @include('portfolios.header')

        <!-- sidebar navigation -->
        <nav class="portfolio-container__portfolio-nav">
            <div class="portfolio-nav">
                <ul>
                    <li><a href="#">Überblick</a></li>
                    <li><a href="#">Transaktionen</a></li>
                    <li><a href="#">Marktwerte</a></li>
                    <li><a href="#">Risiko</a></li>
                    <li><a href="#">Optimieren</a></li>
                </ul>
            </div>
        </nav>

        <!--content-portfolio -->
        <main class="portfolio-container__portfolio-body">
            @yield('portfolio-container-content')
        </main>

        <!-- footer -->
        <footer></footer>

    </section>



@endsection



