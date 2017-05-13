<?php

namespace Tests\Unit\Repos\Metadata;

use App\Entities\Dataset;
use App\Entities\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Metadata\QuandlSSE;


class QuandlSSETest extends TestCase
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
        $this->meta->load();

        $this->assertEquals(5, count(Stock::all()));
    }
}
