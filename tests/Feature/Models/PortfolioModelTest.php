<?php

namespace Tests\Feature\Models;

use App\Entities\Asset;
use App\Entities\Portfolio;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioModelTest extends TestCase
{
    use RefreshDatabase;

    private $portfolio;


    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->states('EUR')->create();
    }


    public function test_it_obtains_an_asset()
    {
        $asset = factory(Asset::class)->create();
        $this->portfolio->obtain($asset);

        $this->assertEquals($asset->id, $this->portfolio->assets->first()->id);
    }
}
