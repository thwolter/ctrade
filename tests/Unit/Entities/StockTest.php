<?php

namespace Tests\Unit\Entities;

use App\Entities\Currency;
use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Sector;
use App\Entities\Security;
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

    protected $currency = 'EUR';
    protected $code = 'XYZ';
    protected $name = 'Fake Name';
    protected $sector = 'Example Sector';
    
    protected $providerName = 'Quandl';
    protected $databaseCode = 'SSE';
    protected $datasetCode = 'ALV';


    public function setUp()
    {
        parent::setUp();

        $this->createStock();
        $this->assignPathway();
    }


    private function createStock()
    {
        factory(Currency::class)
            ->create(['code' => $this->currency])
            ->stocks()
            ->create(['name' => $this->name]);

        $this->stock = Stock::where('name', $this->name)->first();

        Sector::FirstOrCreate(['name' => $this->sector])->stocks()->save($this->stock);
    }
    
    private function assignPathway()
    {
        $this->dataset = factory(Dataset::class)->create(['code' => $this->datasetCode]);
        $this->dataset->stocks()->attach($this->stock->id);
        
        $this->database = factory(Database::class)->create(['code' => $this->databaseCode]);
        $this->database->datasets()->attach($this->dataset->id);
        
        $this->provider = factory(Provider::class)->create(['name' => $this->providerName]);
        $this->provider->databases()->attach($this->database->id);
    }


    public function test_stock_has_currency() {

        $this->assertEquals($this->currency, $this->stock->currency->code);
    }



    public function test_stock_has_name() {

        $this->assertEquals($this->name, $this->stock->name);
    }



    public function test_stock_has_sector() {

        $this->assertEquals($this->sector, $this->stock->sector->name);
    }



    public function test_stock_can_be_assigned_to_dataset()
    {
        Dataset::firstOrCreate([
            'code' => 'ALV.DE'
        ])
            ->stocks()
            ->save(factory(Stock::class)->create());

        $code = $this->stock->datasets->first()->code;
        
        $this->assertEquals($this->datasetCode, $code);
    }
    
    
    public function test_stock_has_pathway()
    {
        $expect = [
            'provider' => $this->provider->id,
            'database' => $this->database->id,
            'dataset'  => $this->dataset->id
        ];
        
        $this->assertEquals($expect, $this->stock->pathway()[0]);
        
    }
    
    
    public function test_stock_has_price()
    {
        $price = $this->stock->price();
        
        $this->assertGreaterThan(0, $price);
    }


    public function test_saveWithParameter_saves_stock()
    {
        $name = 'xyz Stock';
        Stock::saveWithParameter($name, 'EUR', 'abc');

        $stock = Stock::whereName($name)->get()->first();

        $this->assertEquals($name, $stock->name);
        $this->assertEquals('EUR', $stock->currency->code);
        $this->assertEquals('abc', $stock->sector->name);

    }
}
