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
        <div class="row">

            <div class="col-md-2 col-sm-4 col-xs-6">
                <deposit-btn
                        event-buy="depositCash" event-sell="withdrawCash">
                </deposit-btn>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6">
                <withdraw-btn
                        event-buy="depositCash" event-sell="withdrawCash">
                </withdraw-btn>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6">
                <a class="btn btn-default disabled">Kredit aufnehmen</a>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6">
                <a data-toggle="modal" href="#searchStocks" class="btn btn-default">Aktien hinzufügen</a>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6">
                <a class="btn btn-default disabled">Fonds hinzufügen</a>
            </div>

        </div>
    </portlet>

    <div id="searchStocks" class="modal fade">
        <search-stock
                portfolio-id="{{ $portfolio->id }}"
                instrument-type="{{ \App\Entities\Stock::class }}"
                submit-route="{{ route('positions.create', [$portfolio->slug, '%entity%', '%instrument%'], false) }}">
        </search-stock>
    </div>

    <cash-trade
            route="{{ route('portfolios.pay', [], false) }}"
            cash="{{ $portfolio->cash() }}"
            id="{{ $portfolio->id }}">
    </cash-trade>


@endsection