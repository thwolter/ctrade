<?php

namespace Tests\Unit\Entities;

use App\Entities\User;
use App\Entities\CcyPair;
use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use App\Entities\Currency;

use App\Models\Pathway;
use App\Repositories\Metadata\QuandlECB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;



class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

  
    /**
     * @test
     */
    public function can_create_new_portfolio_for_a_user()
    {
        $portfolio = new Portfolio(['name' => 'A Test Portfolio', 'cash' => 1000]);
        $portfolio->setCurrency('CHF');
        
        $user = factory(User::class)->create();
        $user->obtain($portfolio);
        
        $this->assertEquals($user->id, Portfolio::whereName('A Test Portfolio')->first()->user->id);
        
        return $portfolio;
    }


    /**
     * @test
     * @depends can_create_new_portfolio_for_a_user
     */ 
    public function portfolio_has_currency_CHF($portfolio)
    {
        $this->assertEquals('CHF', $portfolio->currency->code);
    }
    
    
    /**
     * @test
     * @depends can_create_new_portfolio_for_a_user
     */ 
    public function portfolio_has_cash_1000($portfolio)
    {
        $this->assertEquals(1000, $portfolio->cash);
    }
    
    
     /**
     * @test
     * @depends can_create_new_portfolio_for_a_user
     */ 
     public function can_obtain_a_position($portfolio)
     {
         $stock = factory(Stock::class)->create();
         $portfolio->obtain(10, $stock);
         
         $this->assertEquals($stock->id, $stock->positions()->first()->id);
         
         return $portfolio;
     }
     
     
     /**
     * @test
     * @depends can_obtain_a_position
     */ 
    public function total_equals_position_total($portfolio)
    {
        $stub = $this->createMock(Stock::class);
        $stub->method('price')->willReturn(150);
        
        $this->assertEquals(0, $portfolio->total());
    }

    
    /**
     * @test
     * @depends can_obtain_a_position
     */ 
    public function empty_portfolio_has_array_of_length_0($portfolio)
    {
        $array = $portfolio->toArray();
        
        $this->assertEquals(0, count($array['item']));
    }

    
    
    /**
     * @test
     * @depends can_obtain_a_position
     */ 
    public function will_save_the_position_history($portfolio)
    {
        $tmpdir = $this->tempDirectoroy();
        $portfolio->rscript()->saveSymbols($tmpdir);
dd($portfolio->positions()->first());
        $this->assertTrue(Storage::disk('local')->exists("{$tmpdir}/pos-1.json"));
       
        //Storage::deleteDirectory($tmpdir);
    }   
    
    
}
