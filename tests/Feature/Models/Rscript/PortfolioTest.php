<?php

namespace Tests\Feature\Models\Rscript;


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

    public function test_calculated_risk()
    {
        $risk = $this->rscripter->risk(20, 0.95);
        $this->assertGreaterThan(20, $risk['Total'][0]['Value']);
        $this->assertLessThan(80, $risk['Total'][0]['Value']);

    }


    public function test_receive_historic_portfolio_values()
    {
        $valueHistory = $this->portfolio->rscript()->valueHistory(60);

        $this->assertEquals(60, count($valueHistory['History']));
    }


    public function test_summary_has_figures_and_history()
    {
        $summary = $this->portfolio->rscript()->summary();

        $this->assertArrayHasKey('Risks', $summary);
        $this->assertArrayHasKey('History', $summary);

        $this->assertGreaterThan(5, count($summary['History']));
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
