@extends('layouts.master')

@section('content')


    <div class="alert alert-info">
        <div class="row">
            <div class="col-md-8">
                <p><b>Dein Portfolio wurde erfolgreich erstellt.</b></p>
                <p>Um die Entwicklung deines Portfolios verfolgen zu
                    können, haben wir das Cash Management aktiviert. Mit der Schaltfläche rechts,
                    kannst das Cash Management deaktivieren.</p>
            </div>
            <div class="col-md-4 text-center">
                <button class="btn btn-default">Cash Management deaktivieren</button>
            </div>
        </div>
    </div>

    <portlet title="Portfolio bearbeiten">
        @include('portfolios.partials.transactions')
    </portlet>

@endsection