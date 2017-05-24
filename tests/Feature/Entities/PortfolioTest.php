<?php

namespace Tests\Feature\Entities;

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

    protected $portfolio;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->createPortfolioWithUser();
    }


    /**
     * @test
     */
    public function can_create_new_portfolio_for_a_user()
    {
        $this->assertEquals($this->user->id, Portfolio::whereName('A Test Portfolio')->first()->user->id);
    }


    /**
     * @test
     * @depends can_create_new_portfolio_for_a_user
     */ 
    public function portfolio_has_currency_CHF()
    {
        $this->assertEquals('CHF', $this->portfolio->currency->code);
    }
    
    
    /**
     * @test
     * @depends can_create_new_portfolio_for_a_user
     */ 
    public function portfolio_has_cash_1000()
    {
        $this->assertEquals(1000, $this->portfolio->cash);
    }
    
    
     /**
     * @test
     */
     public function can_obtain_a_position()
     {
         $stock = factory(Stock::class)->create();
         $portfolio = $this->portfolio->obtain(10, $stock);

         $this->assertEquals($stock->id, $portfolio->positions()->first()->id);
     }


    
    /**
     * @test
     * @depends can_create_new_portfolio_for_a_user
     */ 
    public function empty_portfolio_has_array_of_length_0($portfolio)
    {
        $array = $this->portfolio->toArray();
        
        $this->assertEquals(0, count($array['item']));
    }


    /**
     * @test
     */
    public function portfolio_array_includes_all_positions_and_cash()
    {
        $stock1 = factory(Stock::class)->create();
        $stock2 = factory(Stock::class)->create();

        $this->portfolio
            ->obtain(10, $stock1)
            ->obtain(10, $stock2);

        $array = $this->portfolio->toArray();

        $this->assertEquals(2, count($array['item']));
        $this->assertEquals(1000, $array['cash']);
    }


    /** @test */
    public function portfolio_array_has_currency_for_items_and_self()
    {
        $stock1 = factory(Stock::class)->create();
        $stock2 = factory(Stock::class)->create();

        $this->portfolio
            ->obtain(10, $stock1)
            ->obtain(10, $stock2);

        $array = $this->portfolio->toArray();

        $this->assertEquals('CHF', $array['currency']);
        $this->assertEquals('USD', $array['item'][0]['currency']);
        $this->assertEquals('STOCK.1', $array['item'][0]['symbol']);

    }

    /** @test */
    public function portfolio_has_a_currency_code()
    {
        $this->assertEquals('CHF', $this->portfolio->currencyCode());
    }


    protected function createPortfolioWithUser()
    {
        $portfolio = new Portfolio(['name' => 'A Test Portfolio', 'cash' => 1000]);
        $portfolio->setCurrency('CHF');

        $user = factory(User::class)->create();
        $user->obtain($portfolio);

        $this->user = $user;
        $this->portfolio = $portfolio;
    }


}
