<?php

namespace Tests\Feature\Presenters;

use App\Entities\Portfolio;
use App\Presenters\PortfolioPresenter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioPresenterTest extends TestCase
{

    private $portfolio;

    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->create();
    }


    public function test_it_returns_portfolio_value()
    {
        $this->assertIsString($this->portfolio->present()->value());
    }
}
