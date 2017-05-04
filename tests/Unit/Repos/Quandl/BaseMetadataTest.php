<?php

namespace Tests\Unit\Repos\Quandl;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseMetadataTest extends TestCase
{
    //use DatabaseMigrations;


    protected $meta;


    public function setUp()
    {
        parent::setUp();
        $this->meta = new \App\Repositories\Quandl\BaseMetadata();
    }


    public function testExample()
    {
        $data = $this->meta->load('SSE');
        $this->assertTrue(true);
    }
}
