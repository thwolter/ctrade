<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

    public function Setup()
    {
        parent::SetUp();
        $this->portfolio = factory('App\Portfolio')->create();
        $this->user = factory('App\User')->create();
    }


    public function testUserCanSeeAllPortfolios()
    {
        $response = $this->get('/portfolios');
        $response->assertSee($this->portfolio->name);

    }


    public function testUserCanSeeSinglePortfolio()
    {
        $portfolio = factory('App\Portfolio')->create();

        $response = $this->get('/portfolios/1');
        $response->assertSee($this->portfolio->name);
    }

    public function testUserCanCreatePortfolio()
    {


    }
}
