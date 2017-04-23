@extends('layouts.master')

@section('content')

    <section class="ct-panel">

        @include('portfolios.header')

        <!-- sidebar navigation -->
        <div class="ct-panel__ct-nav">

            @include('portfolios.nav')

        </div>

        <!--content-portfolio -->
        <main class="ct-panel__ct-body">

            @yield('container-content')

        </main>

        <!-- footer -->
        <footer></footer>



    </section>

@endsection



