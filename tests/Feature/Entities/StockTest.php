<?php

namespace Tests\Feature\Entities;

use App\Entities\Currency;
use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Sector;
use App\Entities\Security;
use App\Entities\Datasource;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Stock;

class StockTest extends TestCase
{
    use DatabaseMigrations;

    protected $stock;


    public function setUp()
    {
        parent::setUp();
        
        $this->stock = Stock::saveWithParameter([
            'name' => 'Allianz',
            'currency' => 'EUR',
            'sector' => 'Insurance'
        ]);
        Datasource::make('Quandl', 'SSE', 'ALV')->assign($this->stock);
    }


    public function test_stock_has_currency() {

        $this->assertEquals('EUR', $this->stock->currency->code);
    }


    public function test_stock_has_name() {

        $this->assertEquals('Allianz', $this->stock->name);
    }


    public function test_stock_has_sector() {

        $this->assertEquals('Insurance', $this->stock->sector->name);
    }
    
    
    public function test_stock_has_datasource()
    {
        $this->assertEquals('Quandl', $this->stock->datasources->first()->provider->code);
    }
    
    
    public function test_stock_has_price()
    {
        $this->assertGreaterThan(0, $this->stock->price());
    }


    public function test_stock_has_history()
    {
        $this->assertEquals(250, count($this->stock->history(['limit' => 250])));
    }
    
    
    public function test_stock_has_VaR()
    {
        $this->assertGreaterThan(0, $this->stock->ValueAtRisk());
    }

    /** @test */
    public function stock_has_a_currency_code()
    {
        $this->assertEquals('EUR', $this->stock->currencyCode());
    }
}
