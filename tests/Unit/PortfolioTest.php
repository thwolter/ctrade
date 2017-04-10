<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PortfolioTest extends TestCase
{

    use DatabaseMigrations;

    public function test_portfolio_total_equals_positions_total_for_one_position()
    {
        $position = factory('App\Position')->create();
        $portfolio = $position->portfolio;
        $this->assertEquals($position->total(), $portfolio->total());
    }


}
