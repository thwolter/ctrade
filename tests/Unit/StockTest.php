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
        $this->stock = factory('App\Stock')->create();
    }

    public function test_price_is_a_number()
    {
        $this->assertGreaterThan(0, $this->stock->price());
    }
}
