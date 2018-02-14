<?php

namespace Tests\Feature\Presenters;

use App\Classes\Output\Price;
use App\Entities\Portfolio;
use App\Facades\PortfolioService;
use App\Facades\ValueService\ValueService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioPresenterTest extends TestCase
{

    private $portfolio;

    private $price;


    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->create();
        $this->price = new Price(null, 123, $this->portfolio->currency->code);
    }


    /**
     * @throws \Exception
     */
    public function test_methods_returns_value()
    {
        ValueService::shouldReceive('portfolioValue')->once()->andReturn($this->price);

        $this->assertEquals($this->price, $this->portfolio->present()->value());
    }


    /**
     * @throws \Exception
     */
    public function test_methods_returns_balance()
    {
        PortfolioService::shouldReceive('balance')->once()->andReturn($this->price);

        $this->assertEquals($this->price, $this->portfolio->present()->balance());
    }
}
