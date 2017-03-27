<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory('App\User')->create();
    }

    public function testUserCanSeeOwnPortfolios()
    {

        $portfolios = factory('App\Portfolio', 3)->create(['user_id' => $this->user->id]);

        $page = $this->actingAs($this->user)->get('/portfolios');

        foreach ($portfolios as $portfolio) {
            $page->assertSee($portfolio->name);
        };


    }
}
