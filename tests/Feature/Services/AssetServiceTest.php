<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Facades\AssetService;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\FakeAssetsTrait;
use Tests\Traits\FakePortfolioTrait;

/**
 * Class AssetServiceTest
 * @package Tests\Feature\Services
 */
class AssetServiceTest extends TestCase
{
    use RefreshDatabase;
    use FakeAssetsTrait;
    use FakePortfolioTrait;

    private $trades = [
        ['price' => 10, 'number' => 1, 'fxrate' => 1.2, 'executed_at' => '2017-12-01'],
        ['price' => 20, 'number' => 2, 'fxrate' => 1.5, 'executed_at' => '2017-12-05'],
        ['price' => 15, 'number' => -1, 'fxrate' => 1.1, 'executed_at' => '2017-12-10'],
        ['price' => 18, 'number' => -2, 'fxrate' => 1.3, 'executed_at' => '2017-12-15'],
    ];


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_price_for_domestic_asset()
    {
        $asset = factory(Asset::class)->states('domestic')->create();

        $currency = $asset->portfolio->currency;
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, $currency));

        $expect = new Price($date, 25, $currency);
        $this->assertEquals($expect, AssetService::convertedPriceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_price_for_foreign_asset()
    {
        $asset = factory(Asset::class)->states('foreign')->create();

        $currency = $asset->portfolio->currency;
        $date = '2017-12-12';

        $price = new Price($date, 123, $currency);
        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn($price);

        $this->assertEquals($price, AssetService::priceAt($asset, $date));
    }


    public function test_return_the_converted_asset_price_for_foreign_asset()
    {
        $asset = factory(Asset::class)->states('foreign')->create();
        $currency = $asset->portfolio->currency;
        $date = '2017-12-12';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 123, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, $currency));

        $expect = new Price($date, 123 * 1.2, $currency);

        $this->assertEquals($expect, AssetService::convertedPriceAt($asset, $date));
    }


    public function test_return_the_converted_asset_price_for_domestic_asset()
    {
        $asset = factory(Asset::class)->states('domestic')->create();
        $currency = $asset->portfolio->currency;
        $date = '2017-12-12';

        $price = new Price($date, 123, $currency);
        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn($price);

        $this->assertEquals($price, AssetService::convertedPriceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);

        $currency = $asset->portfolio->currency;
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 123, $currency));

        $expect = new Price($date, 3 * 123, $currency);
        $this->assertEquals($expect, AssetService::valueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, $currency));

        $expect = new Price($date, 3 * 25 * 1.2, $currency);
        $this->assertEquals($expect, AssetService::convertedValueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_converted_asset_value_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, $currency));

        $expect = new Price($date, 3 * 25 * 1.2, $currency);
        $this->assertEquals($expect, AssetService::convertedValueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_converted_asset_value_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-06';

        $price = new Price($date, 25, $currency);
        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn($price);

        $this->assertEquals($price, AssetService::convertedValueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_yield_is_trading_price_difference_at_trading_date_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);

        $currency = $asset->portfolio->currency;
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 11, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, $currency));

        $this->assertEquals(1.2, AssetService::convertedYield($asset, $date)->value, '', 0.001);
    }


    /**
     * @throws \Exception
     */
    public function test_yield_is_trading_price_difference_at_trading_date_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);

        $currency = $asset->portfolio->currency;
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')
            ->twice()
            ->andReturn(new Price($date, 11, $currency));

        $this->assertEquals(1, AssetService::convertedYield($asset, $date)->value, '', 0.001);
        $this->assertEquals(1, AssetService::yield($asset, $date)->value, '', 0.001);
    }

    /**
     * @throws \Exception
     */
    public function test_yield_is_value_difference_after_trading_date_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);

        $currency = $asset->portfolio->currency;
        $date = '2017-12-02';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 12, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, $currency));

        $this->assertEquals(2.4, AssetService::convertedYield($asset, $date)->value, '', 0.001);
    }


    /**
     * @throws \Exception
     */
    public function test_yield_is_value_difference_after_trading_date_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);

        $currency = $asset->portfolio->currency;
        $date = '2017-12-02';

        DataService::shouldReceive('priceAt')
            ->twice()
            ->andReturn(new Price($date, 12, $currency));

        $this->assertEquals(2, AssetService::convertedYield($asset, $date)->value, '', 0.001);
        $this->assertEquals(2, AssetService::yield($asset, $date)->value, '', 0.001);
    }


    /**
     * @throws \Exception
     */
    public function test_get_yield_for_a_day_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);
        
        $currency = $asset->portfolio->currency;
        $date = now();
         
        DataService::shouldReceive('priceAt')
            ->twice()
            ->andReturn(new Price($date, 12, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->twice()
            ->andReturn(new Price($date, 1.2, $currency));
            
        $this->assertEquals(0, AssetService::convertedYieldPeriod($asset, 1)->value);
    }


    /**
     * @throws \Exception
     */
    public function test_get_yield_for_a_day_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);

        $currency = $asset->portfolio->currency;
        $date = now();

        DataService::shouldReceive('priceAt')
            ->times(4)
            ->andReturn(new Price($date, 12, $currency));

        $this->assertEquals(0, AssetService::convertedYieldPeriod($asset, 1)->value);
        $this->assertEquals(0, AssetService::yieldPeriod($asset, 1)->value);
    }

    //todo: implement tests for yieldPercent both for converted and for periods
}
