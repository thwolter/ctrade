<?php

namespace Tests;

use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use App\Models\Pathway;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;




    public function makePortfolio($currency)
    {
        $portfolio = factory('App\Entities\Portfolio')->create(['currency' => $currency]);
        $portfolio->positions()->save($this->makePosition(10, 'ALV.DE'));
        $portfolio->positions()->save($this->makePosition(20, 'BAS.DE'));
        $portfolio->positions()->save($this->makePosition(30, 'YHOO'));

        return $portfolio;
    }

    public function makePosition($amount, $symbol)
    {
        $position = new Position(['amount' => $amount]);
        $stock = Stock::create(['symbol' => $symbol]);

        $stock->positions()->save($position);
        return $position;
    }



    public function makePortfolioWithStock($currency, $amount, $symbol)
    {
        $position = new Position(['amount' => $amount]);
        $stock = Stock::create(['symbol' => $symbol]);
        $portfolio = factory('App\Entities\Portfolio')->create(['currency' => $currency]);

        $stock->positions()->save($position);
        $portfolio->positions()->save($position);
        return $portfolio;
    }

    public function makePositionWithPortfolio($currency, $amount, $symbol)
    {
        $stock = Stock::saveWithParameter([
            'name' => $symbol,
            'currency' => $currency,
            'sector' =>'A sector'
        ]);
        Pathway::make('Quandl', 'SSE', $symbol)->assign($stock);

        $position = new Position(['amount' => $amount]);
        $portfolio = factory(Portfolio::class)->create(['currency' => $currency]);

        $stock->positions()->save($position);
        $portfolio->positions()->save($position);
        $position->save();


        return $position;
    }

    
    public function tempDirectoroy() {
        
        $tmpdir = 'tmp/'.uniqid();
        Storage::makeDirectory($tmpdir);

        return $tmpdir;
    }
}
