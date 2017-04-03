@extends('layouts.master')

@section('content')

    <div>
        <!-- header-portfolio -->
        <div class="header-portfolio">
            <div class="pull-left">
                <span class="title">Mein Europa Portfolio</span>
                <a href="#"><icon class="glyphicon glyphicon-pencil">Bearbeiten</a>
            </div>
            <div class="pull-right">
                <span class="key">Aktuell</span>
                <span class="value">1.200,33</span>
            </div>
            <div class="pull-right">
                <span class="key">Risiko</span>
                <span class="value">234,43</span>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr>

        <div class="portfolio-wrapper">
            <!-- nav-portfolio -->
            <div class="navbar-portfolio">
                <ul class="nav navbar-nav">
                    <li><a href="#">Überblick</a></li>
                    <li><a href="#">Transaktionen</a></li>
                    <li><a href="#">Marktwerte</a></li>
                    <li><a href="#">Risiko</a></li>
                    <li><a href="#">Optimieren</a></li>
                </ul>
            </div>
        </div>


        <!--content-portfolio -->
        <div class="content-portfolio">
            <p> here goes content</p>
        </div>

        <div class="clearfix"></div>
        <btn class="btn btn-primary pull-right">Neue Transaktion</btn>



    </div>







    <!-- show single portfolio -->
    <div class="panel panel-default">
        <div class="panel-heading">Portfolios</div>

        <div class="panel-body">

            <article>
                <h4>
                    {{ $portfolio->name }}
                </h4>
                <div class="body">
                    {{ $portfolio->currency }}
                </div>


                <div class="input-group-btn">

                    <a

                    <a class="btn btn-primary inline-block-tight pull-right"
                       href="/portfolios/{{ $portfolio->id }}/edit">Edit</a>


                    <form method="post" action="/portfolios/{{ $portfolio->id }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-default inline-block-tight pull-right">Löschen</button>
                    </form>

                </div>
            </article>

        </div>
    </div>
@endsection



