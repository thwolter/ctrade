<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Portfolio;

class PortfolioControllerTest extends TestCase
{
    
    use DatabaseMigrations;
    

    public function setUp()
    {
        parent::setUp();
        $this->user = factory('App\Entities\User')->create();
        factory('App\Entities\Currency')->create();
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
    
    
    /**
     * @test
     */ 
     public function user_can_create_a_first_portfolio()
     {
        $response = $this->actingAs($this->user)->call('POST', '/portfolios', [
            'name' => 'Sally', 
            'cash' => 0,
            'currency' => 1]);
            
        $response->assertRedirect('portfolios/1');
     }
    
    
    /**
     * @test
     * 
     */ 
     public function user_cannot_create_a_portfolio_with_existing_name()
     {
        $portfolio = factory(Portfolio::class)->create([
            'user_id' => $this->user->id,
            'name' => 'A Test Portfolio']);
        
        $response = $this->actingAs($this->user)->call('POST', '/portfolios', [
            'name' => 'A Test Portfolio', 
            'cash' => 1,
            'currency' => 1]);
        
        $response->assertRedirect('/');
     }
     
     
     /**
     * @test
     * 
     */ 
     public function user_cannot_create_portolio_with_unavailable_currency()
     {
         $response = $this->actingAs($this->user)->call('POST', '/portfolios', [
            'name' => 'A Test Portfolio', 
            'cash' => 1,
            'currency' => 60]);
        
        $response->assertRedirect('/');
     }
}
