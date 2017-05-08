<?php

namespace Tests\Unit\Entities;

use App\Entities\Currency;
use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Sector;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Stock;

class StockTest extends TestCase
{
    use DatabaseMigrations;

    protected $stock;

    protected $currency = 'EUR';
    protected $code = 'XYZ';
    protected $name = 'Fake Name';
    protected $sector = 'Example Sector';


    public function setUp()
    {
        parent::setUp();

        $this->stock = $this->createStock();
    }


    private function createStock()
    {
        factory(Currency::class)
            ->create(['code' => $this->currency])
            ->stocks()
            ->create(['name' => $this->name]);

        $stock = Stock::where('name', $this->name)->first();

        Sector::FirstOrCreate(['name' => $this->sector])->stocks()->save($stock);

        return $stock;
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
        Dataset::firstOrCreate(['code' => $this->code])
            ->stocks()
            ->save($this->stock);

        $code = $this->stock->datasets->first()->code;
        
        $this->assertEquals($this->code, $code);
    }
    
    public function test_stock_has_pathway()
    {
        $dataset = factory(Dataset::class)->create();
        $dataset->stocks()->attach($this->stock->id);
        
        $database = factory(Database::class)->create();
        $database->datasets()->attach($dataset->id);
        
        $provider = factory(Provider::class)->create();
        $provider->databases()->attach($database->id);
        
        $expect = [
            'provider' => $provider->id,
            'database' => $database->id,
            'dataset'  => $dataset->id
        ];
        
        $this->assertEquals($expect, $this->stock->pathway());
        
        
        
        
    }
}
