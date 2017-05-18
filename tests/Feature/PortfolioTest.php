<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\User;
use App\Entities\Portfolio;


class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory('App\Entities\User')->create();
    }

    /**
     * @test
     */ 
    public function user_can_see_all_own_portfolios()
    {
        $portfolios = factory(Portfolio::class, 3)->create(['user_id' => $this->user->id]);

        $page = $this->actingAs($this->user)->get('/portfolios');

        foreach ($portfolios as $portfolio) {
            $page->assertSee($portfolio->name);
        };
    }
    
    /**
     * @test
     */ 
    public function user_can_see_single_portfolio()
    {
        $portfolio = factory(Portfolio::class)->create(['user_id' => $this->user->id]);
        
        $this->actingAs($this->user)
            ->get('/portfolios/'.$portfolio->id)
            ->assertSee($portfolio->name);
    }
    
    /**
     * @test
     */ 
    public function user_cannot_see_foreign_portfolios()
    {
        $portfolio = factory(Portfolio::class)->create(['user_id' => $this->user->id + 1]);

        $this->actingAs($this->user)
            ->get('/portfolios')
            ->assertDontSee($portfolio->name);
    }


}
