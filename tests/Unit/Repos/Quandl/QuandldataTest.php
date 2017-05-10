<?php

namespace Tests\Unit\Repos\Quandl;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Dataset;
use App\Entities\Stock;
use App\Models\Pathway;
use App\Repositories\Quandl\Quandldata;

class QuandldataTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
        
        $stock = Stock::saveWithParameter('Allianz', 'EUR', 'Industry');
        Pathway::make('Quandl', 'SSE', 'ALV')->assign($stock);
    }
    
    
    public function test_stock_has_price()
    {
        $path = Pathway::withDatasetCode('ALV')->first();
        $price = Quandldata::make($path)->price();
        
        $this->assertGreaterThan(0, $price);
    }
}
