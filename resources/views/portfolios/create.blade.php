@extends('layouts.master')

@section('content')

    @php ($focus = 'Portfolio erstellen')

    <div class="content">
        <div class="container">

            @if (count(Auth::user()->portfolios) == 0)
                <div>
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                        <strong>Willkommen!</strong> Lege hier dein erstes Portfolio an.
                    </div> <!-- /.alert -->
                </div>
            @endif


            <div class="row">
                <div class ="col-md-12">
                    <portlet title="Portfolio erstellen">

                        <div class="col-md-8">
                            <create-portfolio
                                    route="{{ route('portfolios.store', [], true) }}"
                                    :currencies="{{ json_encode($currencies) }}">
                            </create-portfolio>
                        </div>

                        <div class="col-md-4">
                            <p>Ein Portfolio hat eine Währung und einen Anfangs Cashbestand.
                                Du kannst später deinem Portfolio Wertpapiere zuordnen und Cash
                                ein- und auszahlen.
                            </p>
                            <p>Bitte beachte, dass die Währung des Portfolios nachträglich nicht
                                geändert werden kann.
                            </p>
                        </div>
    
                    </portlet> <!-- /portlet -->
                </div>
            </div> <!-- /.row -->


        </div> <!-- /.container -->
    </div> <!-- /.content -->
    

@endsection
