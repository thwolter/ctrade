@extends('layouts.master')

@section('content')

    <section class="portfolio-container">

        <!-- portfolio header -->
        <div class="portfolio-container__portfolio-header">

            <header class="portfolio-header">
                <span class="title">Mein Europa Portfolio</span>
                <a href="#" class="link"><icon class="glyphicon glyphicon-pencil"></icon>Bearbeiten</a>

                <div class="portfolio-header__key-figures">
                    <div class="key-figure">
                        <label class="label">Aktuell</label>
                        <span class="value">1.200,33</span>
                    </div>

                    <div class="key-figure">
                        <label class="label">Risiko</label>
                        <span class="value">234,43</span>
                    </div>
                </div>
            </header>
        </div>

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



