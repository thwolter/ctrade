<?php

namespace Tests\Unit\Yahoo;

use App\Repositories\Yahoo\StockFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

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
    
    
    public function test_makeHistory_saves_jsonfile() {
        
        $today = \Carbon\Carbon::today()->format('Y-m-d');
        
        $filename1 = $this->stock->makeHistory('ALV.DE');
        $filename2 = $this->stock->startDate("2017-01-01")->period(20)->makeHistory('ALV.DE');
        
        $this->assertEquals("Histories/{$today}/ALV.DE_250.json", $filename1);
        $this->assertEquals("Histories/2017-01-01/ALV.DE_20.json", $filename2);
        
        $this->assertTrue(Storage::disk('local')->exists("Histories/{$today}/ALV.DE_250.json"));
        $this->assertTrue(Storage::disk('local')->exists("Histories/2017-01-01/ALV.DE_20.json"));

        Storage::delete($filename1);
        Storage::delete($filename2);
 
    }
}
