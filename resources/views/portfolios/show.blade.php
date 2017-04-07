@extends('layouts.master')

@section('content')

    <section class="portfolio-container">
        <header class="portfolio-header">
            <h2 class="title">Mein Europa Portfolio</h2>
            <a href="#"><icon class="glyphicon glyphicon-pencil"></icon>Bearbeiten</a>

            <div class="value-box">
                <label class="label">Aktuell</label>
                <span class="value">1.200,33</span>
            </div>

            <div class="value-box">
                <label class="label">Risiko</label>
                <span class="value">234,43</span>
            </div>
        </header>

        <div class="portfolio-content">
            <!-- sidebar navigation -->
            <nav class="nav-portfolio">
                <ul>
                    <li><a href="#">Überblick</a></li>
                    <li><a href="#">Transaktionen</a></li>
                    <li><a href="#">Marktwerte</a></li>
                    <li><a href="#">Risiko</a></li>
                    <li><a href="#">Optimieren</a></li>
                </ul>
            </nav>

            <!--content-portfolio -->
            <div class="content-cell">
                <p> here goes content</p>
            </div>

        </div>
    </section>







@endsection



