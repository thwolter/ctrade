<?php


use App\Entities\Stock;
use Illuminate\Support\Facades\Artisan;


Route::get('metadata/update/{database}', function($database) {
    Artisan::call('metadata:update', ['database' => $database]);
});


Route::get('quandl/{database}/{symbol}', function($database, $symbol) {
    Artisan::call('metadata:check', [
        'provider' => 'Quandl',
        'database' => $database,
        'symbol' => $symbol
    ]);
});


Route::get('/update/stocks', function() {

    foreach (Stock::all() as $stock) {

        if (! $stock->datasources) {
            $a = $stock->id;
        }

    }
});


Route::get('test', function() {
    return App\Entities\CcyPair::whereSymbol('EURUSD')->first()->price();
});
