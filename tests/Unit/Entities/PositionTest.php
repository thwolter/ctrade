<?php

namespace Tests\Unit;

use App\Entities\Position;
use App\Entities\Stock;
use App\Entities\Portfolio;
use App\Repositories\Yahoo\CurrencyFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionTest extends TestCase
{
    protected $position;

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->position = factory('App\Entities\Position')->create();
    }


    public function test_positions_stock_has_currency()
    {
       $this->assertStringStartsWith('EUR', $this->position->currency());
    }

    public function test_position_stock_has_price()
    {
        $this->assertGreaterThan(0, $this->position->price());
    }

    public function test_position_stock_has_symbol()
    {
        $this->assertEquals('ALV.DE', $this->position->symbol());
    }

    public function test_position_stock_has_name()
    {
        $this->assertStringStartsWith('ALLIANZ', $this->position->name());
    }

    public function test_position_has_amount()
    {
        $this->assertGreaterThan(0, $this->position->amount());
    }

    public function test_position_has_total()
    {
        $this->assertGreaterThan(0, $this->position->total());
    }
    
    
    public function test_convert_USD_into_position_currency() {
        
        $financial = new CurrencyFinancial;
        
        $this->assertEquals($financial->price('EURUSD'), $this->position->convert('USD'));
    }
    
    public function test_total_with_currency_converts_into_this_currency() {
        
        $financial = new CurrencyFinancial;
        
        $rate = $financial->price('EURUSD');
        
        $this->assertEquals($this->position->total() * $rate, $this->position->total('USD'));
        
    }

    public function test_position_total_value_in_original_currency()
    {
        $position = $this->makePositionWithPortfolio('EUR', 5, 'ALV.DE');

        $this->assertEquals(5 * $position->price(), $position->total());
    }
    
    public function test_position_total_value_in_portfolio_currency()
    {
        $position = $this->makePositionWithPortfolio('CZK', 5, 'ALV.DE');
        $currency = new CurrencyFinancial;
        
        $expect = 5 * $position->price() * $currency->price('EURCZK');

        $this->assertEquals($expect, $position->total('CZK'));
    }

    public function test_method_currency_give_position_currency()
    {
        $stock = factory('App\Entities\Stock')->create(['symbol' => 'YHOO']);
        $stock->positions()->save(new Position);

        $position = $stock->positions()->first();

        $this->assertEquals('USD', $position->currency());
    }

    public function test_typeDisp_of_stock_shows_Aktie()
    {
        $stock = factory('App\Entities\Stock')->create(['symbol' => 'YHOO']);
        $stock->positions()->save(new Position);

        $position = $stock->positions()->first();
        
        $this->assertEquals('Aktie', $position->typeDisp());
    }

    public function test_can_create_an_array()
    {
        $position = $this->makePositionWithPortfolio('EUR', 5, 'ALV.DE');
        $array = $position->toArray();

        $this->assertArrayHasKey('name', $array);

        $this->assertEquals('ALV.DE', $array['symbol']);
    }

    public function test_position_has_history()
    {
        $position = $this->makePositionWithPortfolio('EUR', 5, 'ALV.DE');

        $json = $position->history();

        $this->assertTrue(is_string($json) and is_array(json_decode($json, true)));
    }
}
