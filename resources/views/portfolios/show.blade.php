@extends('layouts.master')

@section('content')

   @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

            <!-- Sidebar -->
           @include('layouts.partials.sidebar')

            <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">

                <div class="g-mb-55">
                    <div class="u-heading-v3-1 g-mb-40">
                        <h2 class="h3 u-heading-v3__title">Kennzahlen</h2>
                    </div>

                    <div class="row text-center text-uppercase">
                        <div class="col-lg-3 col-sm-6 g-mb-50">
                            <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Portfoliowert</span>
                            <div class="g-font-size-35 g-font-weight-300 g-mb-7">
                                {{ $portfolio->present()->total() }}
                            </div>
                            <p> {{ $portfolio->present()->updatedValue() }}</p>
                        </div>

                        <div class="col-lg-3 col-sm-6 g-mb-50">
                            <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Barbestand</span>
                            <div class="js-counter g-font-size-35 g-font-weight-300 g-mb-7">
                                {{ $portfolio->present()->cash() }}
                            </div>
                            <p>{{ $portfolio->present()->updatedToday() }}</p>
                        </div>

                        <div class="col-lg-3 col-sm-6 g-mb-50">
                            <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Gewinn/Verlust</span>
                            <div class="js-counter g-font-size-35 g-font-weight-300 g-mb-7">
                                {{  $portfolio->present()->profit() }}
                            </div>
                            <p>{{ $portfolio->present()->updatedValue() }}</p>

                        </div>

                        <div class="col-lg-3 col-sm-6 g-mb-50">
                            <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Risiko</span>
                            <div class="js-counter g-font-size-35 g-font-weight-300 g-mb-7">
                                {{ $portfolio->present()->risk() }}
                            </div>
                            <p>{{ $portfolio->present()->updatedRisk() }}</p>
                        </div>
                    </div>
                    <p>Gemäß deiner Einstellungen wird die Rendite auf Basis der Historie von
                        {{ $portfolio->settings()->human()->get('returnPeriod') }} angezeigt. Das
                        Risiko ist berechnet für einen zukünftigen Zeitraum von
                        {{ $portfolio->settings()->human()->get('period') }}.
                    </p>
                </div>


                <div class="g-mb-55">
                    <div class="u-heading-v3-1 g-mb-40">
                        <h2 class="h3 u-heading-v3__title">Wertentwicklung</h2>
                    </div>

                    <value-chart
                            pid="{{ $portfolio->id }}"
                            date="{{ \Carbon\Carbon::today()->toDateString() }}"
                            conf="{{ 0.95 }}"
                            count="{{ 50 }}"
                            height="100px">
                    </value-chart>
                </div>

                <div class="g-mb-55">
                    <div class="u-heading-v3-1 g-mb-40">
                        <h2 class="h3 u-heading-v3__title">Positionen</h2>
                    </div>

                    <positions-chart pid="{{ $portfolio->id }}"></positions-chart>
                </div>

            </div>

        </div>
    </div>



    {{--<limit-stats pid="{{ $portfolio->id }}"></limit-stats>--}}



@endsection

