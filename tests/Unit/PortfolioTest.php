<?php

namespace Tests\Unit;

use App\Entities\Portfolio;
use App\Entities\Position;
use App\Repositories\FinancialRepository;
use App\Entities\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PortfolioTest extends TestCase
{

    use DatabaseMigrations;

    public function test_EUR_portfolio_has_currency_EUR()
    {
        $portfolio = factory('App\Entities\Portfolio')->create(['currency' => 'EUR']);
        $this->assertEquals('EUR', $portfolio->currency());
    }



    public function test_portfolio_total_equals_positions_total_for_one_position()
    {
        $portfolio = $this->makePortfolio('EUR', 10, 'ALV.DE');

        $expect = 10 * FinancialRepository::make('Stock', ['symbol'=>'ALV.DE'])->price;

        $this->assertEquals($expect, $portfolio->total());
    }


    public function makePortfolio($currency, $amount, $symbol)
    {
        $position = new Position(['amount' => $amount]);
        $stock = Stock::create(['symbol' => $symbol]);
        $portfolio = factory('App\#entities\Portfolio')->create(['currency' => $currency]);

        $stock->positions()->save($position);
        $portfolio->positions()->save($position);
        return $position;
    }

}
