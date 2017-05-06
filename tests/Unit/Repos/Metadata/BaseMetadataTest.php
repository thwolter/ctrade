<?php

namespace Tests\Unit\Repos\Metadata;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Metadata\BaseMetadata;


class BaseMetadataTest extends TestCase
{
    use DatabaseMigrations;


    protected $meta;


    public function setUp()
    {
        parent::setUp();
        $this->meta = new BaseMetadata();
    }


    public function testExample()
    {
        $this->meta->load('SSE');
        $data = BaseMetadata::all();
        $this->assert(true);
    }
}
