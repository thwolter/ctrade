<?php

namespace Tests\Unit\Entities;

use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Provider;
use App\Entities\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatasetTest extends TestCase
{
    use DatabaseMigrations;

    public function attachStock($dataset)
    {
        $stock = factory(Stock::class)->create();
        $dataset->stocks()->attach($stock->id);
    }


    public function attachDataset($stock)
    {
        $dataset = factory(Dataset::class)->create();
        $stock->datasets()->attach($dataset->id);
    }


    public function test_can_assign_two_stocks()
    {
        $dataset = factory(Dataset::class)->create();

        $this->attachStock($dataset);
        $this->attachStock($dataset);

        $stocks = Dataset::whereCode($dataset->code)->first()->stocks;

        foreach ($stocks as $stock)
        {
            $this->assertEquals($dataset->code, $stock->datasets->first()->code);
        }
    }

    public function test_stock_can_have_two_datasets()
    {
        $stock = factory(Stock::class)->create();

        $this->attachDataset($stock);
        $this->attachDataset($stock);

        $datasets = Stock::whereName($stock->name)->first()->datasets;

        foreach ($datasets as $dataset)
        {
            $this->assertEquals($stock->name, $dataset->stocks->first()->name);
        }
    }

    public function test_can_get_provider_ids()
    {
        $dataset = factory(Dataset::class)->create();

        $database = factory(Database::class)->create();
        $database->datasets()->attach($dataset->id);

        $provider1 = factory(Provider::class)->create();
        $provider1->databases()->attach($database->id);

        $provider2 = factory(Provider::class)->create();
        $provider2->databases()->attach($database->id);

        $ids = $dataset->providers();

        $this->assertTrue(array_key_exists($provider1->id, $ids));
        $this->assertTrue(array_key_exists($provider2->id, $ids));
    }

    public function test_hasDatabase_returns_boolean()
    {
        $dataset = factory(Dataset::class)->create();

        $database = factory(Database::class)->create();
        $database->datasets()->attach($dataset->id);

        $this->assertTrue($dataset->hasDatabase($database->id));
        $this->assertFalse($dataset->hasDatabase(555));
    }

    public function test_hasProvider_returns_boolean()
    {
        $dataset = factory(Dataset::class)->create();

        $database = factory(Database::class)->create();
        $database->datasets()->attach($dataset->id);

        $provider = factory(Provider::class)->create();
        $provider->databases()->attach($database->id);

        $this->assertTrue($dataset->hasProvider($provider->id));
        $this->assertFalse($dataset->hasProvider(555));
    }
}
