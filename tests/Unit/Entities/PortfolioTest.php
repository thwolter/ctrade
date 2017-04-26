<?php

namespace Tests\Unit\Entities;

use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use App\Repositories\StockFinancial;
use App\Repositories\CurrencyFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;


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
        $portfolio = $this->makePortfolioWithStock('EUR', 10, 'ALV.DE');

        $stock = new StockFinancial;
        $expect = 10 * $stock->price('ALV.DE');

        $this->assertEquals($expect, $portfolio->total());
    }
    
    
    public function test_portfolio_total_for_YHOO()
    {
        $portfolio = $this->makePortfolioWithStock('CZK', 10, 'YHOO');

        $currency = new CurrencyFinancial;
        $stock = new StockFinancial;
        
        $expect = 10 * $stock->price('YHOO') * $currency->price('USDCZK');

        $this->assertEquals($expect, $portfolio->total());
    }
    
    public function test_portfolio_value_for_YHOO_and_cash()
    {
        $portfolio = $this->makePortfolioWithStock('CZK', 10, 'YHOO');

        $currency = new CurrencyFinancial;
        $stock = new StockFinancial;
        
        $expect = 10 * $stock->price('YHOO') * $currency->price('USDCZK') 
            + $portfolio->cash();

        $this->assertEquals($expect, $portfolio->value());
    }

    public function test_can_make_array()
    {
        $portfolio = $this->makePortfolioWithStock('USD', 10, 'ALV.DE');
        $array = $portfolio->toArray();

        $this->assertArrayHasKey('symbol', $array['item'][0]);
    }

    
    public function test_save_required_symbols()
    {
        $tmpdir = $this->tempDirectoroy();
        $this->makePortfolio('EUR')->rscript()->saveSymbols($tmpdir);

        $this->assertTrue(Storage::disk('local')->exists("{$tmpdir}/ALV.DE.json"));
        $this->assertTrue(Storage::disk('local')->exists("{$tmpdir}/BAS.DE.json"));
        $this->assertTrue(Storage::disk('local')->exists("{$tmpdir}/YHOO.json"));
        $this->assertTrue(Storage::disk('local')->exists("{$tmpdir}/EURUSD.json"));

        Storage::deleteDirectory($tmpdir);
    }   
    
    
}
