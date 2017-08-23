@extends('layouts.master')

@section('content')

    @php ($focus = 'Portfolio erstellen')

        <div class="content">
            <div class="container">

                @include('partials.message')

                <div class="row">
                    <div class="col-md-8">
                        <portlet title="Portfolio erstellen">

                            <div class="col-md-12">
                                <create-portfolio
                                        route="{{ route('portfolios.store', [], true) }}"
                                        :currencies="{{ json_encode($currencies) }}"
                                        :categories="{{ json_encode($categories) }}">
                                </create-portfolio>
                            </div>

                        </portlet> <!-- /portlet -->
                    </div>

                    <div class="col-md-4">

                        <div class="info-box">
                            <p>
                                Ein Portfolio hat eine Währung und einen Anfangs Cashbestand.
                                Du kannst später deinem Portfolio Wertpapiere zuordnen und Cash
                                ein- und auszahlen.
                            </p>
                            <p>
                                Bitte beachte, dass die Währung des Portfolios nachträglich nicht
                                geändert werden kann.
                            </p>
                        </div>


                    </div> <!-- /.row -->


                </div> <!-- /.container -->
            </div> <!-- /.content -->


@endsection
