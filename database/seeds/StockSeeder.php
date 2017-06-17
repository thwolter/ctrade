<?php

use Illuminate\Database\Seeder;
use App\Entities\Stock;
use App\Facades\Datasource;
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

        Datasource::make('Quandl', 'SSE', 'ALV')->assign($stockALV);
        Datasource::make('Quandl', 'SSE', 'BAS')->assign($stockBAS);
        Datasource::make('Quandl', 'SSE', 'DAI')->assign($stockDAI);
    }
}
