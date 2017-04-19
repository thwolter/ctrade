<?php

namespace Tests\Unit;

use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use App\Repositories\Yahoo\StockFinancial;
use App\Repositories\Yahoo\CurrencyFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PortfolioTest extends TestCase
{

    use DatabaseMigrations;

    public function test_EUR_portfolio_has_currency_EUR()
    {
        $portfolio = factory('App\Entities\Portfolio')->create(['currency' => 'EUR']);
        $this->assertEquals('EUR', $portfolio->currency());
    }



    public function test_portfolio_total_for_ALV()
    {
        $portfolio = $this->makePortfolio('EUR', 10, 'ALV.DE');

        $stock = new StockFinancial;
        $expect = 10 * $stock->price('ALV.DE');

        $this->assertEquals($expect, $portfolio->total());
    }
    
    
    public function test_portfolio_total_for_YHOO()
    {
        $portfolio = $this->makePortfolio('CZK', 10, 'YHOO');

        $currency = new CurrencyFinancial;
        $stock = new StockFinancial;
        
        $expect = 10 * $stock->price('YHOO') * $currency->price('USDCZK');

        $this->assertEquals($expect, $portfolio->total());
    }
    
    public function test_portfolio_value_for_YHOO_and_cash()
    {
        $portfolio = $this->makePortfolio('CZK', 10, 'YHOO');

        $currency = new CurrencyFinancial;
        $stock = new StockFinancial;
        
        $expect = 10 * $stock->price('YHOO') * $currency->price('USDCZK') 
            + $portfolio->cash();

        $this->assertEquals($expect, $portfolio->value());
    }


    public function makePortfolio($currency, $amount, $symbol)
    {
        $position = new Position(['amount' => $amount]);
        $stock = Stock::create(['symbol' => $symbol]);
        $portfolio = factory('App\Entities\Portfolio')->create(['currency' => $currency]);

        $stock->positions()->save($position);
        $portfolio->positions()->save($position);
        return $portfolio;
    }

}
