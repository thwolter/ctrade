<?php

namespace Tests\Unit\Entities;

use App\Entities\Currency;
use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Sector;
use App\Entities\Security;
use App\Models\Pathway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Stock;

class StockTest extends TestCase
{
    use DatabaseMigrations;

    protected $stock;
    protected $database;
    protected $dataset;
    protected $provider;

    protected $providerName = 'Quandl';
    protected $databaseCode = 'SSE';
    protected $datasetCode = 'ALV';


    public function setUp()
    {
        parent::setUp();

        $this->stock = Stock::saveWithParameter('Allianz', 'EUR', 'Insurance');
        Pathway::make('Quandl', 'SSE', 'ALV')->assign($this->stock);
    }


    public function test_stock_has_currency() {

        $this->assertEquals('EUR', $this->stock->currency->code);
    }


    public function test_stock_has_name() {

        $this->assertEquals('Allianz', $this->stock->name);
    }


    public function test_stock_has_sector() {

        $this->assertEquals('Insurance', $this->stock->sector->name);
    }
    
    
    public function test_stock_has_pathway()
    {
        $this->assertEquals('Quandl', $this->stock->pathway()->first()->provider->code);
    }
    
    
    public function test_stock_has_price()
    {
        $this->assertGreaterThan(0, $this->stock->price());
    }


    public function test_stock_has_history()
    {
        $this->assertJson($this->stock->history());
    }
}
