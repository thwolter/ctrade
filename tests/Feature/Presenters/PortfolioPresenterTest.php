<?php

namespace Tests\Feature\Presenters;

use App\Entities\Portfolio;
use App\Presenters\PortfolioPresenter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioPresenterTest extends TestCase
{

    private $presenter;

    public function setUp()
    {
        parent::setUp();

        $portfolio = factory(Portfolio::class)->create();
        $this->presenter = new PortfolioPresenter($portfolio);
    }

    public function test_it_returns_portfolio_value()
    {
        $this->assertIsString($this->presenter->value());
    }
}
