@extends('layouts.master')

@section('content')

    @php ($focus = 'Portfolio erstellen')

    <div class="content">
        <div class="container">

            @if (count(Auth::user()->portfolios) == 0)
                <div>
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                        <strong>Willkommen!</strong> Du bist dabei, dein erstes Portfolio anzulegen.
                    </div> <!-- /.alert -->
                </div>
            @endif


            <div class="row">
                <div class ="col-md-12">
                    <portlet title="Portfolio erstellen">
    
                        <create-portfolio
                                route="{{ route('portfolios.store', [], true) }}"
                                :currencies="{{ json_encode($currencies) }}">
                        </create-portfolio>
    
                    </portlet> <!-- /portlet -->
                </div>
            </div> <!-- /.row -->

            @include('portfolios.partials.help')

        </div> <!-- /.container -->
    </div> <!-- /.content -->
    

@endsection
