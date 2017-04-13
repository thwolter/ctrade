<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->stock = factory('App\Stock')->create(['symbol' => 'ALV.DE']);
    }

    public function test_price_is_a_number()
    {
        $this->assertGreaterThan(0, $this->stock->price());
    }

    public function test_currency_equals_EUR()
    {
        $this->assertStringStartsWith('EUR', $this->stock->currency());
    }

    public function test_name_includes_Allianz()
    {
        $this->assertStringStartsWith('ALLIANZ', $this->stock->name());
    }
}
