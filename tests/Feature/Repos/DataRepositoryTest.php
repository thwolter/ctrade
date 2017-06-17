<?php

namespace Tests\Feature\Repos;

use App\Facades\Datasource;
use App\Repositories\DataRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DataRepositoryTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function ALV_has_a_history()
    {
        Datasource::make('Quandl', 'SSE', 'ALV');
        $data = new DataRepository(Datasource::withDataset('ALV'));
        $this->assertGreaterThan(0, $data->history());
    }

    /** @test */
    public function EURUSD_has_a_history()
    {
        Datasource::make('Quandl', 'ECB', 'EURUSD');
        $data = new DataRepository(Datasource::withDataset('EURUSD'));
        $this->assertGreaterThan(0, $data->history());
    }

    /** @test */
    public function ALV_has_a_price()
    {
        Datasource::make('Quandl', 'SSE', 'ALV');
        $data = new DataRepository(Datasource::withDataset('ALV'));
        $this->assertGreaterThan(0, $data->price());
    }

    /** @test */
    public function EURUSD_has_a_price()
    {
        Datasource::make('Quandl', 'ECB', 'EURUSD');
        $data = new DataRepository(Datasource::withDataset('EURUSD'));
        $this->assertGreaterThan(0, $data->price());
    }
    
    
    /** @test */
    public function if_two_datasources_are_given_it_takes_the_first()
    {
        Datasource::make('Quandl', 'SSE', 'ALV');
        Datasource::make('Fake', null, 'ALV');
        $data = new DataRepository(Datasource::withDataset('ALV'));
        $this->assertGreaterThan(0, $data->price());
    }
}
