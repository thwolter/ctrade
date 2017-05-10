<?php

namespace Tests\Unit\Entities;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Provider;
use App\Entities\Stock;
use App\Models\Pathway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatasetTest extends TestCase
{
    use DatabaseMigrations;


    public function setUp()
    {
        parent::setUp();

        $stockA = Stock::saveWithParameter('Allianz', 'EUR', 'Insurance');
        $stockB = Stock::saveWithParameter('Allianz 2', 'EUR', 'Chemical');

        Pathway::make('Quandl', 'SSE', 'ALV')->assign($stockA);
        Pathway::make('Yahoo', 'Yahoo', 'ALV')->assign($stockA);

        Pathway::make('Another', 'Another', 'ALV')->assign($stockB);

    }


    public function test_can_assign_two_stocks_on_a_dataset()
    {
        $stocks = Dataset::whereCode('ALV')->first()->stocks;

        foreach ($stocks as $stock) {
            $this->assertEquals('ALV', $stock->datasets->first()->code);
        }


    }

    public function test_stock_can_have_two_datasets()
    {
        $datasets = Stock::whereName('Allianz')->first()->datasets;

        foreach ($datasets as $dataset) {
            $this->assertEquals('Allianz', $dataset->stocks->first()->name);
        }
    }


    public function test_can_get_provider_ids()
    {
        $ids = Dataset::whereCode('ALV')->first()->providers();

        $this->assertTrue(in_array('Quandl', $ids));
        $this->assertTrue(in_array('Yahoo', $ids));
    }


    public function test_hasDatabase_returns_boolean()
    {
        $dataset = Dataset::whereCode('ALV')->first();
        $database = Database::whereCode('SSE')->first();

        $this->assertTrue($dataset->hasDatabase($database->id));
        $this->assertFalse($dataset->hasDatabase(555));
    }


    public function test_hasProvider_returns_boolean()
    {
        $dataset = Dataset::whereCode('ALV')->first();
        $provider = Provider::whereCode('Yahoo');

        $this->assertTrue($dataset->hasProviderWithId(Provider::whereCode('Yahoo')->first()->id));
        $this->assertTrue($dataset->hasProviderWithCode(Provider::whereCode('Quandl')->first()->code));

        $this->assertFalse($dataset->hasProviderWithId(555));
    }


    public function test_saveWithPath_saves_stock()
    {
        $providers = Dataset::whereCode('ALV')->first()->providers();

        $this->assertContains('Quandl', $providers);
        $this->assertContains('Yahoo', $providers);
    }
}
