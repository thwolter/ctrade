<?php

namespace Tests\Feature\Models;

use App\Entities\CcyPair;
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

        $stock = Stock::saveWithParameter([
            'name' => 'Allianz',
            'currency' => 'EUR',
            'sector' => 'Industry'
        ]);

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

    /** @test */
    public function can_assign_a_currency_pair()
    {
        $cpair = factory(CcyPair::class)->create([
            'origin' => 'EUR',
            'target' => 'USD'
        ]);
        Pathway::make('Quandl', 'ECB', 'EURUSD')->assign($cpair);

        $this->assertEquals('Quandl', $cpair->pathway()->first()->provider->code);
    }

    /** @test */
    public function make_returns_a_pathway_with_path()
    {
        $pathway = Pathway::make('Quandl', 'SSE', 'ALV');

        $this->assertInstanceOf(Pathway::class, $pathway);
        $this->assertEquals('Quandl', $pathway->first()->provider->code);
    }

    /** @test */
    public function a_pathway_can_be_persited()
    {
        Pathway::make('Quandl', 'SSE', 'ALV')->save();
        $code = Pathway::withDatasetCode('ALV')->first()->provider->code;

        $this->assertEquals('Quandl', $code);
    }
    
    /** @test */
    public function returns_a_pathway_or_null()
    {
        Pathway::make('Quandl', 'SSE', 'ALV')->save();
        $pw_exist = Pathway::get('Quandl', 'SSE', 'ALV');
        $pw_fails = Pathway::get('Quandl', 'SSE', 'BAS');

        $this->assertTrue(get_class($pw_exist) == Pathway::class);
        $this->assertEquals(NULL, $pw_fails);
    }

}

