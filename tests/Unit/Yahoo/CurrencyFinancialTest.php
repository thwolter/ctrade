<?php

namespace Tests\Unit\Yahoo;

use App\Repositories\Yahoo\CurrencyFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CurrencyFinancialTest extends TestCase
{

    protected $currency;

    public function setUp() {

        parent::setUp();

        $this->currency = new CurrencyFinancial;
    }

    
    public function test_price_is_positive() {

        $this->assertGreaterThan(0, $this->currency->price('EURUSD'));
    }
    
    
    public function test_name_has_currency_name() {
        
        $this->assertStringStartsWith('EUR/USD', $this->currency->name('EURUSD'));
    }
    
    public function test_currency_has_currency_currency() {
        
        $this->assertEquals('USD', $this->currency->currency('EURUSD'));
    }
    
    public function test_type_is_stock() {
        
        $this->assertEquals('Currency', $this->currency->type('EURUSD'));
        
        $this->assertEquals('Currency', $this->currency->type());
    }
}
