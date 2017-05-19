<?php

use Illuminate\Database\Seeder;
use App\Entities\Stock;
use App\Models\Pathway;
use App\Entities\Currency;

class StockSeeder extends Seeder
{

    public function run()
    {
        $stockALV = Stock::firstOrNew(['name' => 'Allianz']);
        $stockBAS = Stock::firstOrNew(['name' => 'Basf']);
        $stockDAI = Stock::firstOrNew(['name' => 'Daimler']);

        $currency = Currency::whereCode('EUR')->first();
        $stockALV->currency()->associate($currency)->save();
        $stockBAS->currency()->associate($currency)->save();
        $stockDAI->currency()->associate($currency)->save();

        Pathway::make('Quandl', 'SSE', 'ALV')->assign($stockALV);
        Pathway::make('Quandl', 'SSE', 'BAS')->assign($stockBAS);
        Pathway::make('Quandl', 'SSE', 'DAI')->assign($stockDAI);
    }
}
