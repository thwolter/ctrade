<?php

namespace Tests\Unit\Repos\Quandl;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MetadataTest extends TestCase
{
    use DatabaseMigrations;


    protected $meta;


    public function setUp()
    {
        parent::setUp();
        $this->meta = new \App\Repositories\Quandl\Metadata();
    }


    public function testExample()
    {
        $data = meta->load('SSE');
        $this->assertTrue(true);
    }
}
