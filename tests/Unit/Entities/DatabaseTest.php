<?php

namespace Tests\Unit\Entities;

use App\Entities\Database;
use App\Entities\Dataset;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseTest extends TestCase
{
    use DatabaseMigrations;

    public function test_database_can_have_many_datasets()
    {
        $database = factory(Database::class)->create();

        $this->attachDataset($database);
        $this->attachDataset($database);

        $datasets = Database::whereCode($database->code)->first()->datasets;

        foreach ($datasets as $dataset)
        {
            $this->assertEquals($database->code, $dataset->databases->first()->code);
        }
    }

    public function test_dataset_can_have_many_databases()
    {
        $dataset = factory(Dataset::class)->create();

        $this->attachDatabase($dataset);
        $this->attachDatabase($dataset);

        $databases = Dataset::whereCode($dataset->code)->first()->databases;

        foreach ($databases as $database)
        {
            $this->assertEquals($dataset->code, $database->datasets->first()->code);
        }

    }

    public function attachDataset($database)
    {
        $dataset = factory(Dataset::class)->create();
        $database->datasets()->attach($dataset->id);
    }


    public function attachDatabase($dataset)
    {
        $database = factory(Database::class)->create();
        $dataset->databases()->attach($database->id);
    }
}
