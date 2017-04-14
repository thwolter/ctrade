<?php

namespace Tests\Unit\Yahoo;

use App\Repositories\Yahoo\StockFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockFinancialTest extends TestCase
{

    protected $stock;

    public function setUp() {

        parent::setUp();

        $this->stock = StockFinancial::make(['symbol'=>'ALV.DE']);
    }

    public function test_symbol_can_be_read() {

        $this->assertStringStartsWith('ALV.DE', $this->stock->symbol);
    }

    public function test_price_is_positive() {

        $this->assertGreaterThan(0, $this->stock->price());
    }
}
