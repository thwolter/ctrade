@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            <div class="row">

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Portfoliowert')
                        @slot('value', $portfolio->present()->total())
                        @slot('date', $portfolio->present()->updatedValue());
                        @slot('icon', 'fa-pie-chart');
                    @endcomponent
                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Barbestand')
                        @slot('value', $portfolio->present()->cash())
                        @slot('date', $portfolio->present()->updatedToday());
                        @slot('icon', 'fa-university');
                    @endcomponent
                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Risiko ('.$portfolio->settings()->human()->get('period').')')
                        @slot('value', $portfolio->present()->risk())
                        @slot('date', $portfolio->present()->updatedRisk());
                        @slot('icon', 'fa-tachometer');
                    @endcomponent
                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Rendite (30 Tage)')
                        @slot('value', $portfolio->present()->total())
                        @slot('date', 'now');
                        @slot('icon', 'fa-line-chart');
                    @endcomponent
                </div> <!-- /.col-md-3 -->
            </div>

            <div class="row">

                <div class="col-md-5">
                    <portlet title="Positionen">
                        <positions-chart pid="{{ $portfolio->id }}"></positions-chart>
                    </portlet>
                </div>


                <div class="col-md-7">
                    <portlet title="Wertentwicklung">
                        <value-chart pid="{{ $portfolio->id }}" height="100px"></value-chart>
                    </portlet>
                </div>


                <div class="col-md-4">
                    <portlet title="Limitauslastung">
                        <limit-stats pid="{{ $portfolio->id }}"></limit-stats>
                    </portlet>
                </div>

                <div class="col-md-6">
                    <portlet title="Risikoentwicklung">
                        <p>a line chart</p>
                    </portlet>
                </div>

                <div class="col-md-6">
                    <portlet title="Verteilung des Risikos">
                        <p>a donut chart</p>
                    </portlet>
                </div>

            </div> <!-- /.row -->

        </div> <!-- /.container -->
    </div> <!-- /.content -->



@endsection



@section('scripts.footer')

@endsection