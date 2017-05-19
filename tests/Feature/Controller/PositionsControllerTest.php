<?php

namespace Tests\Feature\Controller\PositionsControllerTest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionsControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $portfolio;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory('App\Entities\Portfolio')->create();
        $this->user = $this->portfolio->user;
    }

    public function test_position_can_be_stored()
    {
        $response = $this->actingAs($this->user)->get(
            route('positions.store', ['portfolio_id' => $this->portfolio->id, 'symbol' => 'ALV.DE', 'type'=> 'S'])
        );

        $response->assertStatus(200);
    }
}
