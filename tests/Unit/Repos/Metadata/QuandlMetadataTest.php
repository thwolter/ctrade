<?php

namespace Tests\Unit\Repos\Metadata;

use App\Entities\Dataset;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Metadata\QuandlMetadata;


class QuandlMetadataTest extends TestCase
{
    use DatabaseMigrations;


    protected $meta;


    public function setUp()
    {
        parent::setUp();
        $this->meta = new QuandlMetadata();
    }


    public function testExample()
    {
        $this->meta->load('SSE');
        //$data = BaseMetadata::all();
        $this->assertTrue(true);
    }
}
