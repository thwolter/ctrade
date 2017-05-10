<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Stock;
use App\Entities\Dataset;
use App\Models\Pathway;

class PathwayTest extends TestCase
{
    
    use DatabaseMigrations;


    public function setUp()
    {
        parent::setUp();

        $stock = Stock::saveWithParameter('Allianz', 'EUR', 'Industry');

        Pathway::make('Quandl', 'SSE', 'ALV')->assign($stock);
        Pathway::make('Yahoo', 'Yahoo', 'ALV')->assign($stock);

    }


    public function test_can_assign_pathway()
    {
        $this->assertTrue(Dataset::whereCode('ALV')->first()->hasProviderWithCode('Quandl'));
    }


    public function test_first_provider_is_Quandl()
    {
        $datasets = Stock::whereName('Allianz')->first()->datasets;

        $path = Pathway::withDatasets($datasets)->first();
        $this->assertEquals('Quandl', $path->provider->code);

        $path->next();
        $this->assertEquals('Yahoo', $path->provider->code);

        $this->assertEquals(null, $path->next());
    }
    
    
    public function test_can_call_with_id_1()
    {
        $this->assertEquals('Quandl', Pathway::withDatasetId(1)->first()->provider->code);
    }
    
    
    public function test_can_call_with_code_ALV()
    {
        $this->assertEquals('Quandl', Pathway::withDatasetCode('ALV')->first()->provider->code);
    }
}

