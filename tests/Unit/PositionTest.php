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

    public function makePortfolio($currency, $amount, $symbol): Position
    {
        $position = new Position(['amount' => $amount]);
        $stock = Stock::create(['symbol' => $symbol]);
        $portfolio = factory('App\Entities\Portfolio')->create(['currency' => $currency]);

        $stock->positions()->save($position);
        $portfolio->positions()->save($position);
        return $position;
    }


    public function test_positions_stock_has_currency()
    {
       $this->assertStringStartsWith('EUR', $this->position->currency());
    }

    public function test_position_stock_has_price()
    {
        $this->assertGreaterThan(0, $this->position->price());
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

    public function test_position_total_value_in_original_currency()
    {
        $position = $this->makePortfolio('EUR', 5, 'ALV.DE');

        $this->assertEquals(5 * $position->price(), $position->total());
    }
    
    public function test_position_total_value_in_portfolio_currency()
    {
        $position = $this->makePortfolio('CZK', 5, 'ALV.DE');
        $currency = new CurrencyFinancial;
        
        $expect = 5 * $position->price() * $currency->price('EURCZK');

        $this->assertEquals($expect, $position->total(true));
    }

    public function test_method_currency_give_position_currency()
    {
        $stock = factory('App\Entities\Stock')->create(['symbol' => 'YHOO']);
        $stock->positions()->save(new Position);

        $position = $stock->positions()->first();

        $this->assertEquals('USD', $position->currency());
    }



}
