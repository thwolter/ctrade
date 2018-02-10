<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Position;
use App\Facades\AssetService;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetServiceTest extends TestCase
{

    use RefreshDatabase;


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

        $expect = new Price($date, 25*1.2, 'EUR');
        $this->assertEquals($expect, AssetService::priceAt($asset, $date));
    }


    public function test_it_returns_the_asset_value_in_domestic_currency()
    {
        $asset = factory(Asset::class)->states('domestic')->create();
        $asset->obtain($this->createPosition(['price' => 15, 'amount' => 2]));
        $date = '2017-12-12';

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($date, 25, 'EUR'));

        $expect = new Price($date, 2 * 25, 'EUR');
        $this->assertEquals($expect, AssetService::value($asset));
    }


    public function test_it_returns_the_asset_value_in_foreign_currency()
    {
        $asset = factory(Asset::class)->states('foreign')->create();
        $asset->obtain($this->createPosition(['price' => 15, 'amount' => 2]));
        $date = '2017-12-12';

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
     * @return mixed
     */
    private function createPosition($array)
    {
        $position = factory(Position::class)->create();
        $position->update($array);

        return $position;
    }
}
