<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Classes\TimeSeries;
use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Portfolio;
use App\Facades\AssetService;
use App\Facades\DataService;
use App\Facades\PortfolioService;
use App\Facades\CurrencyService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\FakeHistoryTrait;

class PortfolioServiceTest extends TestCase
{

    use FakeHistoryTrait;

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
       AssetService::shouldReceive('convertedValueAt')
           ->once()
           ->andReturn(new Price(now(), 123, $portfolio->currency));
       $this->assertEquals(123, PortfolioService::value($asset->portfolio)->value);
   }


    /**
     * @throws \Exception
     */
    public function test_returns_the_portfolios_price_history()
   {
       $portfolio = factory(Portfolio::class)->states('EUR')->create();
       $dAsset = factory(Asset::class)->states('domestic')->create(['portfolio_id' => $portfolio->id]);
       $fAsset = factory(Asset::class)->states('foreign')->create(['portfolio_id' => $portfolio->id]);

       DataService::shouldReceive('history')
           ->twice()->andReturn(new TimeSeries($this->data, $this->columns));

       CurrencyService::shouldReceive('history')
           ->once()->andReturn(new TimeSeries($this->dataReciprocal, $this->columns));

       $assetTs = (new TimeSeries($this->data, $this->columns))
           ->weekdays()->fill()->from('2017-12-22')->to('2017-12-29')->getClose();

       $currencyTs = (new TimeSeries($this->dataReciprocal, $this->columns))
           ->weekdays()->fill()->from('2017-12-22')->to('2017-12-29')->getClose();

       $expect = [
           $dAsset->label => $assetTs,
           $fAsset->label => $assetTs,
           $fAsset->positionable->currency->code => $currencyTs
       ];

       $this->assertEquals($expect, PortfolioService::priceHistory($portfolio, [
           'from' => '2017-12-22', 'to' => '2017-12-29'
       ]));
   }


    /**
     * @throws \Exception
     */
    public function test_returns_the_portfolio_absoluteReturn_for_domestic_assets()
   {
       $portfolio = factory(Portfolio::class)->states('EUR')->create();
       factory(Asset::class)->states('domestic')->create(['portfolio_id' => $portfolio->id]);
       factory(Asset::class)->states('domestic')->create(['portfolio_id' => $portfolio->id]);

       AssetService::shouldReceive('convertedYield')
           ->twice()->andReturn(new Price(now(), 10, 'EUR'));

       $expect = new Price(now(), 20, 'EUR');

       $this->assertEquals($expect, PortfolioService::absoluteReturn($portfolio));
   }

    /**
     * @throws \Exception
     */
    public function test_returns_the_portfolio_absoluteReturn_for_foreign_assets()
    {
        $this->markTestSkipped('foreign asset return to be implemented');

        $portfolio = factory(Portfolio::class)->states('EUR')->create();
        factory(Asset::class)->states('domestic')->create(['portfolio_id' => $portfolio->id]);
        factory(Asset::class)->states('foreign')->create(['portfolio_id' => $portfolio->id]);

        AssetService::shouldReceive('convertedYield')
            ->twice()->andReturn(new Price(now(), 10, 'EUR'));

        $expect = new Price(now(), 20, 'EUR');

        $this->assertEquals($expect, PortfolioService::absoluteReturn($portfolio));
    }
}
