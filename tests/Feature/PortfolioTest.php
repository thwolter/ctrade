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


    public function test_user_can_see_all_own_portfolios()
    {
        $portfolios = factory('App\Portfolio', 3)->create(['user_id' => $this->user->id]);

        $page = $this->actingAs($this->user)->get('/portfolios');

        foreach ($portfolios as $portfolio) {
            $page->assertSee($portfolio->name);
        };
    }
    
    
    public function test_user_can_see_single_portfolio()
    {
        $this->portfolio = factory('App\Portfolio')->create(['user_id' => $this->user->id]);
        
        $this->actingAs($this->user)
            ->get('/portfolios/'.$this->portfolio->id)
            ->assertSee($this->portfolio->name);
    }
    
    
    public function test_user_cannot_see_foreign_portfolios()
    {
        $portfolio = factory('App\Portfolio')->create(['user_id' => $this->user->id + 1]);

        $this->actingAs($this->user)
            ->get('/portfolios')
            ->assertDontSee($portfolio->name);
    }


}
