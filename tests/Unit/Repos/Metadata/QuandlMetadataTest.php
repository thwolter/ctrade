<?php

namespace Tests\Unit\Repos\Metadata;

use App\Entities\Dataset;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Metadata\QuandlSSE;


class QuandlMetadataTest extends TestCase
{
    use DatabaseMigrations;


    protected $meta;


    public function setUp()
    {
        parent::setUp();
        $this->meta = new QuandlSSE();
    }


    public function testExample()
    {
        $this->meta->loadDatabase('SSE');
        //$data = BaseMetadata::all();
        $this->assertTrue(true);
    }
}
