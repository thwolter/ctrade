<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Position;
use App\Facades\AccountService;
use App\Facades\ValueService\ValueService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValueServiceTest extends TestCase
{

    private $portfolio;


    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->states('EUR')->create();

        $this->portfolio->obtain($this->assetWithPositions(3));
        $this->portfolio->obtain($this->assetWithPositions(1));
        $this->portfolio->obtain($this->assetWithPositions(0));

    }


    public function test_it_returns_the_asset_value()
    {
        $assets = factory(Asset::class)->create();
        $assets->obtain($this->createPosition(['price' => 10, 'amount' => 1]));


    }


    public function x_test_it_returns_the_portfolio_value()
    {
        AccountService::shouldReceive('balance')
            ->once()
            ->andReturn(new Price(null, 0, 'EUR'));

        $value = ValueService::portfolioValue($this->portfolio);

        $this->assertIsClass(Price::class, $value);
    }

    /**
     * @return mixed
     */
    private function assetWithPositions($count)
    {
        $asset = factory(Asset::class)->create();

        if ($count)
        {
            foreach (factory(Position::class, $count)->create() as $position) {
                $asset->obtain($position);
            }
        }

        return $asset;
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
