@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            <div class="row">

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Wert')
                        @slot('value', $portfolio->present()->total())
                    @endcomponent
                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Barbestand')
                        @slot('value', $portfolio->present()->cash())
                    @endcomponent
                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Risiko (30 Tage)')
                        @slot('value', $portfolio->present()->total())
                    @endcomponent
                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">
                    @component('partials.icon-stat')
                        @slot('label', 'Entwicklung (30 Tage)')
                        @slot('value', $portfolio->present()->total())
                    @endcomponent
                </div> <!-- /.col-md-3 -->

            </div> <!-- /.row -->

            <div class="row">
                <div class="container">
                    @component('partials.portlet-boxed')
                        @slot('title', 'Positions')
                        <p>present a positions table</p>
                    @endcomponent
                </div>
            </div> <!-- /.row -->

            <div class="row">

                <div class="col-md-6">
                    @component('partials.portlet-boxed')
                        @slot('title', 'Entwicklung')
                        <p>a line chart</p>
                    @endcomponent
                </div>

                <div class="col-md-6">
                    @component('partials.portlet-boxed')
                        @slot('title', 'Entwicklung')
                        <p>a line chart</p>
                    @endcomponent
                </div>

            </div> <!-- /.row -->

        </div> <!-- /.container -->
    </div> <!-- /.content -->



@endsection