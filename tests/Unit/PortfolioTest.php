<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PortfolioTest extends TestCase
{

    use DatabaseMigrations;

    public function test_EUR_portfolio_has_currency_EUR()
    {
        $portfolio = factory('App\Portfolio')->create(['currency' => 'EUR']);
        $this->assertEquals('EUR', $portfolio->currency());
    }

    public function test_portfolio_has_total_value()
    {
        $portfolio = factory('App\Portfolio')->create();

        $this->assertGreaterThan(0, $portfolio->total());
    }

    public function test_portfolio_total_equals_positions_total_for_one_position()
    {
        $position = factory('App\Position')->create(['currency' => 'EUR']);
        $portfolio = $position->portfolio;
        $this->assertEquals($position->total(), $portfolio->total());
    }



}
