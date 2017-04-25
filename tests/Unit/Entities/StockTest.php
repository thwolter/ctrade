<?php

namespace Tests\Unit\Models;

use App\Entities\Position;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Stock;

class StockTest extends TestCase
{

    use DatabaseMigrations;



    private function createStock($symbol)
    {
        $portfolio = factory('App\Entities\Portfolio')->create();

        $stock = Stock::firstOrCreate(['symbol'=> $symbol]);

        $position = new Position();
        $stock->positions()->save($position);
        $portfolio->positions()->save($position);

        return $stock;
    }

/*
    public function test_position_is_created()
    {
        $this->createStock('ALV.DE');

        $this->assertDatabaseHas('stocks', ['symbol' => 'ALV.DE']);
    }
*/

    public function test_stock_has_price() {

        $stock = $this->createStock('BAS.DE');

        $this->assertGreaterThan(0, $stock->price());
    }


    public function test_stock_has_currency() {

        $stock = $this->createStock('BAS.DE');

        $this->assertStringStartsWith('EUR', $stock->currency());
    }


    public function test_stock_has_name() {

        $stock = $this->createStock('BAS.DE');

        $this->assertStringStartsWith('BASF', $stock->name());
    }
    
    
    public function test_isCurrency_for_same_curreny_is_true()
    {
        $stock = $this->createStock('BAS.DE');
        
        $this->assertTrue($stock->isCurrency('EUR'));
        $this->assertFalse($stock->isCurrency('USD'));
    }
    
    
    public function test_has_history()
    {
        $stock = $this->createStock('BAS.DE');
        $json = $stock->financial()->history($stock->symbol); 
        
        $this->assertTrue(is_string($json) and is_array(json_decode($json, true)));
    }
   
}
