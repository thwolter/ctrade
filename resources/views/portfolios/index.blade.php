@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            @include('partials.message')

            @php( $focus = 'Meine Portfolios' )

                @if (count($portfolios) == 0)

                    <portlet title="Portfolio anlegen">
                        @include('portfolios.partials.welcome')
                    </portlet>

                    @if ($examples)
                        <portlet id="examples" title="Beispiele">
                            @foreach($examples as $portfolio)
                                @include('portfolios.partials.item')
                            @endforeach
                        </portlet>
                    @endif

                @else

                    @foreach($portfolios as $portfolio)
                        @php $route = route('portfolios.show', ['slug' => $portfolio->slug]) @endphp

                        <portlet title="{{ $portfolio->name }}">

                            <div class="portfolio-box">
                                <div class="col-xs-6">
                                    <p>{{ $portfolio->description }}</p>
                                </div>
                                <div class="keyfigure col-xs-2">
                                    <div class="keyfigure-title">
                                        Value
                                    </div>
                                    <div class="keyfigure-number">
                                        2.000,00€
                                    </div>
                                </div>
                                <div class="keyfigure col-xs-2">
                                    <div class="keyfigure-title">
                                        Value
                                    </div>
                                    <div class="keyfigure-number">
                                        2.000,00€
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <a href="#">Öffnen</a>
                                </div>
                            </div>
                        </portlet>

                    @endforeach


                @endif
        </div>
    </div>


@endsection


