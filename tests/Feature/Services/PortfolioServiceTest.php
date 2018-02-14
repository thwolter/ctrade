<?php

namespace Tests\Feature\Services;

use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Portfolio;
use App\Facades\AssetService;
use App\Facades\PortfolioService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioServiceTest extends TestCase
{


    /**
     * @throws \Exception
     */
    public function test_calls_portfolio_balance_method_and_returns_price()
   {
       $payment = factory(Payment::class)->create(['amount' => 123]);

       $this->assertEquals(123, PortfolioService::balance($payment->portfolio)->value);
   }


    /**
     * @throws \Exception
     */
    public function test_return_portfolio_value_in_portfolio_currency()
   {
       $portfolio = factory(Portfolio::class)->create();
       $this->assertEquals(0, PortfolioService::value($portfolio)->value);

       $asset = factory(Asset::class)->create();
       AssetService::shouldReceive('valueAt')->once()->andReturn(123);
       $this->assertEquals(123, PortfolioService::value($asset->portfolio)->value);
   }
}
