<?php

namespace Tests\Unit\Models;

use App\Position;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Stock;

class StockTest extends TestCase
{

    use DatabaseMigrations;



    private function createStock($symbol)
    {
        $portfolio = factory('App\Portfolio')->create();

        $stock = Stock::firstOrCreate(['symbol'=> $symbol]);

        $position = new Position();
        $stock->positions()->save($position);
        $portfolio->positions()->save($position);

        return $stock;
    }


    public function test_position_is_created()
    {
        $this->createStock('ALV.DE');

        $this->assertDatabaseHas('stocks', ['symbol' => 'ALV.DE']);
    }

    public function test_blade_is_defined()
    {
        $stock = $this->createStock('ALV.DE');

        $this->assertStringStartsWith('instruments.stock', $stock->blade());
    }

    public function test_stock_has_price() {

        $stock = $this->createStock('BAS.DE');

        $this->assertGreaterThan(0, $stock->price());
    }

    public function test_stock_has_currency() {

        $stock = $this->createStock('BAS.DE');

        $this->assertStringStartsWith('EUR', $stock->currency());
    }

    public function test_stock_blade_equals_instrument_blade()
    {
        $stock = $this->createStock('BAS.DE');
        $this->assertStringStartsWith('instruments.stock', $stock->blade());
    }

}
