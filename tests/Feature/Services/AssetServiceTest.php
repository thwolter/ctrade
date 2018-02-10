<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Position;
use App\Facades\AssetService;
use App\Facades\DataService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetServiceTest extends TestCase
{

    use RefreshDatabase;


    public function test_it_returns_the_price_at_given_date()
    {

    }

    public function test_it_returns_the_asset_value_in_domestic_currency()
    {
        $asset = factory(Asset::class)->states('EUR')->create();
        $asset->obtain($this->createPosition(['price' => 15, 'amount' => 2]));

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price(null, 25, 'EUR'));

        $this->assertEquals(50, AssetService::value($asset)->value);
    }


    public function test_it_returns_the_asset_value_in_foreign_currency()
    {
        $asset = factory(Asset::class)->states('EUR')->create();
        $asset->obtain($this->createPosition(['price' => 15, 'amount' => 2]));

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price(null, 25, 'EUR'));

        $this->assertEquals(50, AssetService::value($asset)->value);
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
