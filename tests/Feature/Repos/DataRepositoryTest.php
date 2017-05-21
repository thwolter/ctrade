<?php

namespace Tests\Feature\Repos;

use App\Models\Pathway;
use App\Repositories\DataRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DataRepositoryTest extends TestCase
{
    use DatabaseMigrations;


    public function setUp()
    {
        parent::setUp();

        Pathway::make('Quandl', 'SSE', 'ALV')->save();
        Pathway::make('Quandl', 'ECB', 'EURUSD')->save();
    }

    /** @test */
    public function ALV_has_a_history()
    {
        $data = new DataRepository(Pathway::withDatasetCode('ALV'));
        $this->assertGreaterThan(0, $data->history());
    }

    /** @test */
    public function EURUSD_has_a_history()
    {
        $data = new DataRepository(Pathway::withDatasetCode('EURUSD'));
        $this->assertGreaterThan(0, $data->history());
    }

    /** @test */
    public function ALV_has_a_price()
    {
        $data = new DataRepository(Pathway::withDatasetCode('ALV'));
        $this->assertGreaterThan(0, $data->price());
    }

    /** @test */
    public function EURUSD_has_a_price()
    {
        $data = new DataRepository(Pathway::withDatasetCode('EURUSD'));
        $this->assertGreaterThan(0, $data->price());
    }
}
