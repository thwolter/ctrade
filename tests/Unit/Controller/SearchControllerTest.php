<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\InstrumentController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchControllerTest extends TestCase
{

    use DatabaseMigrations;

    protected $user;
    protected $portfolio;

    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory('App\Portfolio')->create();
        $this->user = $this->portfolio->user;
    }

    public function test_search_show_works()
    {
        $response = $this->actingAs($this->user)->get(
            route('search.show', ['portfolio' => $this->portfolio->id, 'symbol' => 'ALV.DE', 'type'=> 'S'])
        );

        $response->assertViewHas('instrument');
    }

}
