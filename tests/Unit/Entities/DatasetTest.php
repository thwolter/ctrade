<?php

namespace Tests\Unit\Entities;

use App\Entities\Dataset;
use App\Entities\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatasetTest extends TestCase
{
    use DatabaseMigrations;

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

    public function attachStock($dataset)
    {
        $stock = factory(Stock::class)->create();
        $dataset->stocks()->attach($stock->id);

        return $stock;
    }


    public function attachDataset($stock): mixed
    {
        $dataset = factory(Dataset::class)->create();
        $stock->datasets()->attach($dataset->id);
        return $dataset;
    }
}
