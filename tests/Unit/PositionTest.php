<?php

namespace Tests\Unit;

use App\Position;
use App\Stock;
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

        $this->position = factory('App\Position')->create();
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

    public function test_position_total_value_is_correct_in_same_currency()
    {
        $position = new Position(['amount' => 5]);
        $stock = new Stock(['symbol' => 'ALV.DE']);
        $stock->positions()->save($stock);

        $this->assertEquals(5 * $position->price(), $position->total());
    }
}
