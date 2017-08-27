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

                        <portlet title="Portfolio: {{ $portfolio->name }}">

                            <div class="portfolio-box">

                                <div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <span>Beschreibung:</span>
                                        {!! $portfolio->present()->description() !!}
                                    </div>

                                    <div class="keyfigure col-md-2 col-sm-3 col-xs-12">
                                        <div class="keyfigure-title">Wert</div>
                                        <div class="keyfigure-number">
                                            {{ $portfolio->present()->total() }}
                                        </div>
                                    </div>

                                    <div class="keyfigure col-md-2 col-sm-3 col-xs-12">
                                        <div class="keyfigure-title">Risiko</div>
                                        <div class="keyfigure-number">
                                            {{ $portfolio->present()->risk() }}
                                        </div>
                                    </div>

                                    <div class="keyfigure col-md-2 col-sm-3 col-xs-12">
                                        <div class="keyfigure-title">Rendite</div>
                                        <div class="keyfigure-number">
                                            {{ $portfolio->present()->return() }}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div>
                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                                    <a href="{{ route('portfolios.show', $portfolio->slug) }}" class="btn btn-primary">Öffnen</a>
                                </div>
                            </div>


                        </portlet>

                    @endforeach

                @endif
        </div>
    </div>


@endsection


