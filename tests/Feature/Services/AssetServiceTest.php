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
    public function test_it_returns_the_asset_price_in_domestic_currency()
    {
        $asset = factory(Asset::class)->states('domestic')->create();

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, $currency));

        $expect = new Price($date, 25, $currency);
        $this->assertEquals($expect, AssetService::priceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_price_in_foreign_currency()
    {
        $asset = factory(Asset::class)->states('foreign')->create();

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-12';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, $currency));

        $expect = new Price($date, 25 * 1.2, $currency);
        $this->assertEquals($expect, AssetService::priceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_in_domestic_currency()
    {
        $asset = $this->domesticAssetWithTrades($this->trades);

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, $currency));

        $expect = new Price($date, 3 * 25, $currency);
        $this->assertEquals($expect, AssetService::valueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_in_foreign_currency()
    {
        $asset = $this->foreignAssetWithTrades($this->trades);

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, $currency));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, $currency));

        $expect = new Price($date, 3 * 25 * 1.2, $currency);
        $this->assertEquals($expect, AssetService::valueAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_cost_value_is_null_when_asset_has_no_positions()
    {
        $asset = $this->domesticAssetWithTrades($this->trades);

        $this->assertNull(AssetService::costValue($asset, '2017-11-30'));
        $this->assertNull(AssetService::costValue($asset, '2017-12-30'));
    }


    /**
     * @throws \Exception
     */
    public function test_absolute_return_is_trading_price_difference_at_trading_date()
    {
        $asset = $this->domesticAssetWithTrades($this->trades);

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-01';

        AssetService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 11, $currency));

        $this->assertEquals(1, AssetService::returnAbsolute($asset, $date)->value);
    }

    public function test_absolute_return_is_value_difference_after_trading_date()
    {
        $asset = $this->domesticAssetWithTrades($this->trades);

        $currency = $asset->portfolio->currency->code;
        $date = '2017-12-02';

        AssetService::shouldReceive('priceAt')
            ->once()
            ->with($date)
            ->andReturn(new Price($date, 12, $currency));

        AssetService::shouldReceive('priceAt')
            ->once()
            ->with('2017-12-01')
            ->andReturn(new Price($date, 11, $currency));

        $this->assertEquals(1, AssetService::returnAbsolute($asset, $date)->value);
    }
}
