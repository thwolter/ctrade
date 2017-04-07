@extends('layouts.master')

@section('content')

    <section class="ct-panel">

        @include('portfolios.header')

        <!-- sidebar navigation -->
        <div class="ct-panel__ct-nav">
            <nav class="ct-nav">
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
        <main class="ct-panel__ct-body">

            @yield('portfolio-container-content')

        </main>

        <!-- footer -->
        <footer></footer>

    </section>



@endsection



