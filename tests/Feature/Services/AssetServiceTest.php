<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Exceptions\AssetServiceException;
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
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')->once()->andReturn(25);

        $this->assertEquals(25, AssetService::convertedPriceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_price_for_foreign_asset()
    {
        $asset = factory(Asset::class)->states('foreign')->create();
        $date = '2017-12-12';

        DataService::shouldReceive('priceAt')->once()->andReturn(123);

        $this->assertEquals(123, AssetService::priceAt($asset, $date));
    }


    public function test_return_the_converted_asset_price_for_foreign_asset()
    {
        $asset = factory(Asset::class)->states('foreign')->create();
        $date = '2017-12-12';

        DataService::shouldReceive('priceAt')->once()->andReturn(123);
        CurrencyService::shouldReceive('priceAt')->once()->andReturn(1.2);

        $this->assertEquals(123 * 1.2, AssetService::convertedPriceAt($asset, $date));
    }


    public function test_return_the_converted_asset_price_for_domestic_asset()
    {
        $asset = factory(Asset::class)->states('domestic')->create();
        $date = '2017-12-12';

        DataService::shouldReceive('priceAt')->once()->andReturn(123);

        $this->assertEquals(123, AssetService::convertedPriceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')->once()->andReturn(123);

        $this->assertEquals(3 * 123, AssetService::valueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')->once()->andReturn(25);
        CurrencyService::shouldReceive('priceAt')->once()->andReturn(1.2);

        $this->assertEquals(3 * 25 * 1.2, AssetService::convertedValueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_converted_asset_value_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')->once()->andReturn(25);
        CurrencyService::shouldReceive('priceAt')->once()->andReturn(1.2);

        $this->assertEquals(3 * 25 * 1.2, AssetService::convertedValueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_converted_asset_value_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')->once()->andReturn(25);

        $this->assertEquals(25 * $asset->numberAt($date), AssetService::convertedValueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_yield_is_trading_price_difference_at_trading_date_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);

        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')->once()->andReturn(11);
        CurrencyService::shouldReceive('priceAt')->once()->andReturn(1.2);

        $this->assertEquals(1.2, AssetService::convertedYield($asset, $date), '', 0.001);
    }


    /**
     * @throws \Exception
     */
    public function test_yield_is_trading_price_difference_at_trading_date_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')->twice()->andReturn(11);

        $this->assertEquals(1, AssetService::convertedYield($asset, $date), '', 0.001);
        $this->assertEquals(1, AssetService::yield($asset, $date), '', 0.001);
    }

    /**
     * @throws \Exception
     */
    public function test_yield_is_value_difference_after_trading_date_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);
        $date = '2017-12-02';

        DataService::shouldReceive('priceAt')->once()->andReturn(12);
        CurrencyService::shouldReceive('priceAt')->once()->andReturn(1.2);

        $this->assertEquals(2.4, AssetService::convertedYield($asset, $date), '', 0.001);
    }


    /**
     * @throws \Exception
     */
    public function test_yield_is_value_difference_after_trading_date_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);
        $date = '2017-12-02';

        DataService::shouldReceive('priceAt')->twice()->andReturn(12);

        $this->assertEquals(2, AssetService::convertedYield($asset, $date), '', 0.001);
        $this->assertEquals(2, AssetService::yield($asset, $date), '', 0.001);
    }


    /**
     * @throws \Exception
     */
    public function test_get_yield_for_a_day_for_foreign_asset()
    {
        $asset = $this->createAsset($this->trades, false);

        DataService::shouldReceive('priceAt')->twice()->andReturn(12);
        CurrencyService::shouldReceive('priceAt')->twice()->andReturn(1.2);
            
        $this->assertEquals(0, AssetService::convertedYieldPeriod($asset, 1));
    }


    /**
     * @throws \Exception
     */
    public function test_get_yield_for_a_day_for_domestic_asset()
    {
        $asset = $this->createAsset($this->trades, true);

        DataService::shouldReceive('priceAt')->times(4)->andReturn(12);

        $this->assertEquals(0, AssetService::convertedYieldPeriod($asset, 1));
        $this->assertEquals(0, AssetService::yieldPeriod($asset, 1));
    }

    //todo: implement tests for yieldPercent both for converted and for periods
}
