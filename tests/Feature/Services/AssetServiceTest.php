<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Position;
use App\Facades\AssetService;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\FakeAssetsTrait;

/**
 * Class AssetServiceTest
 * @package Tests\Feature\Services
 */
class AssetServiceTest extends TestCase
{
    use RefreshDatabase;
    use FakeAssetsTrait;

    private $trades = [
        ['price' => 10, 'amount' => 1, 'executed_at' => '2017-12-01'],
        ['price' => 20, 'amount' => 2, 'executed_at' => '2017-12-05'],
        ['price' => 15, 'amount' => -1, 'executed_at' => '2017-12-10'],
        ['price' => 18, 'amount' => -2, 'executed_at' => '2017-12-15'],
    ];


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_price_for_asset_in_domestic_currency()
    {
        $asset = factory(Asset::class)->states('domestic')->create();
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, 'EUR'));

        $expect = new Price($date, 25, 'EUR');
        $this->assertEquals($expect, AssetService::priceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_price_for_asset_in_foreign_currency()
    {
        $asset = factory(Asset::class)->states('foreign')->create();
        $date = '2017-12-12';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, 'EUR'));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, 'EUR'));

        $expect = new Price($date, 25 * 1.2, 'EUR');
        $this->assertEquals($expect, AssetService::priceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_in_domestic_currency()
    {
        $asset = $this->createAssetWithTrades($this->trades, 'EUR');
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, 'EUR'));

        $expect = new Price($date, 2 * 25, 'EUR');
        $this->assertEquals($expect, AssetService::valueAt($asset));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_in_foreign_currency()
    {
        $asset = $this->createAssetWithTrades($this->trades, 'EUR');
        $date = '2017-12-06';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, 'EUR'));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 1.2, 'EUR'));

        $expect = new Price($date, 2 * 25 * 1.2, 'EUR');
        $this->assertEquals($expect, AssetService::value($asset));
    }


    /**
     * @throws \Exception
     */
    public function test_returns_the_assets_cost_value()
    {
        $asset = $this->createAssetWithTrades($this->trades, 'EUR');
        $date = '2017-12-06';

        $expect = new Price($date, 50/3, 'EUR');
        $this->assertEquals($expect, AssetService::costValue($asset, $date));

        $this->assertEquals(17.5, AssetService::costValue($asset, '2017-12-10')->value);
    }

    /**
     * @throws \Exception
     */
    public function test_cost_value_is_null_when_asset_has_no_positions()
    {
        $asset = $this->createAssetWithTrades($this->trades);

        $this->assertNull(AssetService::costValue($asset, '2017-11-30'));
        $this->assertNull(AssetService::costValue($asset, '2017-12-30'));
    }


}
