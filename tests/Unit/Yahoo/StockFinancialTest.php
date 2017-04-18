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

        $this->stock = new StockFinancial;
    }

    
    public function test_price_is_positive() {

        $this->assertGreaterThan(0, $this->stock->price('ALV.DE'));
    }
    
    
    public function test_name_has_stock_name() {
        
        $this->assertStringStartsWith('ALLIANZ', $this->stock->name('ALV.DE'));
    }
    
    public function test_currency_has_stock_currency() {
        
        $this->assertEquals('EUR', $this->stock->currency('ALV.DE'));
    }
    
    public function test_type_is_stock() {
        
        $this->assertEquals('Stock', $this->stock->type('ALV.DE'));
        
        $this->assertEquals('Stock', $this->stock->type());
    }
}
