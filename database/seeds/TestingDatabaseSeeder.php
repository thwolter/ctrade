<?php

use Illuminate\Database\Seeder;
use App\Models\Pathway;
use App\Entities\Currency;
use App\Entities\Stock;
use App\Entities\User;
use App\Entities\Portfolio;
use App\Entities\Position;


class TestingDatabaseSeeder extends Seeder
{

    public function run()
    {
        $stockALV = Stock::firstOrNew(['name' => 'Allianz']);
        $stockBAS = Stock::firstOrNew(['name' => 'Basf']);
        $stockDAI = Stock::firstOrNew(['name' => 'Daimler']);

        $ccyEUR = Currency::firstOrCreate(['code' => 'EUR']);
        $ccyUSD = Currency::firstOrCreate(['code' => 'USD']);
        $ccyCHF = Currency::firstOrCreate(['code' => 'CHF']);

        // create 3 stocks with currency EUR
        $ccyEUR->stocks()->save($stockALV);
        $ccyEUR->stocks()->save($stockBAS);
        $ccyEUR->stocks()->save($stockDAI);

        // pathways to Quandl
        Pathway::make('Quandl', 'ECB', 'EURUSD')->assign($stockALV);
        Pathway::make('Quandl', 'ECB', 'EURCHF')->assign($stockALV);

        Pathway::make('Quandl', 'SSE', 'ALV')->assign($stockALV);
        Pathway::make('Quandl', 'SSE', 'BAS')->assign($stockBAS);
        Pathway::make('Quandl', 'SSE', 'DAI')->assign($stockDAI);


        // a user
        $user = factory(User::class)->create();

        // create two portfolios and assign to user
        $portfolioEUR = Portfolio::firstOrNew(['name' => 'Test portfolio in EUR', 'cash' => 2000]);
        $portfolioUSD = Portfolio::firstOrNew(['name' => 'Test portfolio in EUR', 'cash' => 2000]);

        // assign user and currency
        $portfolioEUR->currency()->associate($ccyEUR);
        $portfolioEUR->user()->associate($user);
        $portfolioEUR->save();

        $portfolioUSD->currency()->associate($ccyUSD);
        $portfolioUSD->user()->associate($user);
        $portfolioUSD->save();

        // put stocks into the portfolios
        $this->assignPosition($portfolioEUR, $stockALV, 10);
        $this->assignPosition($portfolioEUR, $stockBAS, 20);
        $this->assignPosition($portfolioEUR, $stockDAI, 30);

        $this->assignPosition($portfolioUSD, $stockALV, 10);
        $this->assignPosition($portfolioUSD, $stockBAS, 20);
        $this->assignPosition($portfolioUSD, $stockDAI, 30);
    }


    private function assignPosition($portfolio, $instrument, $amount)
    {
        $position = new Position(['amount' => $amount]);

        $position->portfolio()->associate($portfolio);
        $position->positionable()->associate($instrument);

        $position->save();


    }
}
