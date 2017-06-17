<?php

namespace Tests\Feature\Entities;

use App\Facades\Datasource;
use App\Entities\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatasourceTest extends TestCase
{
    use DatabaseMigrations;

    public $stock;

    public function setUp()
    {
        parent::setUp();

        $this->stock = Stock::saveWithParameter([
            'name' => 'Allianz',
            'currency' => 'EUR',
            'sector' => 'Industry'
        ]);
    }

    /** @test */
    public function can_save_and_read_a_datasource()
    {
        Datasource::make('Quandl', 'SSE', 'ALV');
        $this->assertEquals('Quandl', Datasource::first()->provider->code);
    }


    /** @test */
    public function a_Quandl_SSE_ALV_datasource_exist()
    {
        Datasource::make('Quandl', 'SSE', 'ALV');
        $this->assertTrue(Datasource::exist('Quandl', 'SSE', 'ALV'));
    }

    /** @test */
    public function can_assign_a_stock()
    {
        Datasource::make('Quandl', 'SSE', 'ALV')
            ->assign($this->stock);

        $this->assertEquals('Allianz', Datasource::first()->stocks->first()->name);
    }
    
    
    /** @test */
    public function can_get_database_code()
    {
        Datasource::make('Quandl', 'SSE', 'ALV')
            ->assign($this->stock);
            
        $this->assertEquals('SSE', Datasource::withDataset('ALV')->first()->database->code);
    }

    /** @test */
    public function can_get_datasources_for_a_provider()
    {
        Datasource::make('Quandl', 'SSE', 'ALV')
            ->assign($this->stock);

        Datasource::make('Yahoo', null, 'ALV')
            ->assign($this->stock);

        $this->assertEquals(1, Datasource::whereProvider('Quandl')->count());
        $this->assertEquals(1, Datasource::whereProvider('Yahoo')->count());
        $this->assertEquals(0, Datasource::whereProvider('xyz')->count());
    }

    /** @test */
    public function can_get_datasources_for_a_database()
    {
        Datasource::make('Quandl', 'SSE', 'ALV')
            ->assign($this->stock);

        Datasource::make('Yahoo', null, 'ALV')
            ->assign($this->stock);

        $this->assertEquals(1, Datasource::whereDatabase('SSE')->count());
        $this->assertEquals(1, Datasource::whereDatabase(null)->count());
        $this->assertEquals(0, Datasource::whereDatabase('xyz')->count());
    }

    /** @test */
    public function can_get_datasources_for_a_dataset()
    {
        Datasource::make('Quandl', 'SSE', 'ALV')
            ->assign($this->stock);

        Datasource::make('Yahoo', null, 'BAS')
            ->assign($this->stock);

        $this->assertEquals(1, Datasource::whereDataset('ALV')->count());
        $this->assertEquals(1, Datasource::whereDataset('BAS')->count());
        $this->assertEquals(0, Datasource::whereDataset('xyz')->count());
    }
}