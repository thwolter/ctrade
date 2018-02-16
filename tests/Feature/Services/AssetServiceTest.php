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
    public function test_it_returns_the_asset_price_in_for_domestic_asset()
    {
        $asset = factory(Asset::class)->states('domestic')->create();

        $currency = $asset->portfolio->currency;
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
    public function test_it_returns_the_asset_price_for_foreign_asset()
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
        $this->assertEquals($expect, AssetService::priceAt($asset, $date));
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_asset_value_for_domestic_asset()
    {
        $asset = $this->domesticAssetWithTrades($this->trades);

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
    public function test_absolute_return_is_trading_price_difference_at_trading_date()
    {
        $asset = $this->createAsset($this->trades);

        $currency = $asset->portfolio->currency;
        $date = '2017-12-01';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 11, $currency));

        $this->assertEquals(1, AssetService::returnAbsolute($asset, $date)->value);
    }

    /**
     * @throws \Exception
     */
    public function test_absolute_return_is_value_difference_after_trading_date()
    {
        $asset = $this->createAsset($this->trades);

        $currency = $asset->portfolio->currency;
        $date = '2017-12-02';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 12, $currency));

        $this->assertEquals(2, AssetService::returnAbsolute($asset, $date)->value);
    }
    
    
    
    public function test_can_calculate_absolute_return_for_a_day()
    {
        $asset = $this->createAsset($this->trades);
        
        $currency = $asset->portfolio->currency;
        $date = now();
         
        DataService::shouldReceive('priceAt')
            ->twice()
            ->andReturn(new Price($date, 12, $currency));
            
        $this->assertEquals(0, AssetService::returnAbsolute($asset, null, 2)->value);
    }
}
