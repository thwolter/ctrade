<?php

use Illuminate\Database\Seeder;
use App\Entities\Currency;
use App\Models\Pathway;

class CurrencySeeder extends Seeder
{

    public function run()
    {
        Currency::firstOrCreate(['code' => 'EUR']);

        $usd = Currency::firstOrCreate(['code' => 'USD']);
        $chf = Currency::firstOrCreate(['code' => 'CHF']);

        $eurusd = \App\Entities\CcyPair::firstOrCreate(['origin' => 'EUR', 'target' => 'USD']);
        $eurchf = \App\Entities\CcyPair::firstOrCreate(['origin' => 'EUR', 'target' => 'CHF']);

        Pathway::make('Quandl', 'ECB', 'EURUSD')->assign($eurusd);
        Pathway::make('Quandl', 'ECB', 'EURCHF')->assign($eurchf);
    }
}
