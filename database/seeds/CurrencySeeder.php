<?php

use Illuminate\Database\Seeder;
use App\Entities\Currency;
use App\Entities\Datasource;

class CurrencySeeder extends Seeder
{

    public function run()
    {
        Currency::firstOrCreate(['code' => 'EUR']);

        $usd = Currency::firstOrCreate(['code' => 'USD']);
        $chf = Currency::firstOrCreate(['code' => 'CHF']);

        $eurusd = \App\Entities\CcyPair::firstOrCreate(['origin' => 'EUR', 'target' => 'USD']);
        $eurchf = \App\Entities\CcyPair::firstOrCreate(['origin' => 'EUR', 'target' => 'CHF']);

        Datasource::make('Quandl', 'ECB', 'EURUSD')->assign($eurusd);
        Datasource::make('Quandl', 'ECB', 'EURCHF')->assign($eurchf);
    }
}
