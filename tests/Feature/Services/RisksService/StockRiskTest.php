<?php

namespace Tests\Feature\Services\RisksService;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Currency;
use App\Entities\Stock;
use App\Exceptions\RiskServiceException;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use App\Services\RiskService\StockRisk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockRiskTest extends TestCase
{
    use RefreshDatabase;


    private $stockRisk;
    private $date;


    public function setUp()
    {
        parent::setUp();

        $this->stockRisk = new StockRisk();
        $this->date = '2017-12-29';
    }


    public function test_throws_exception_if_not_assigned_to_asset()
    {
        $parameter = ['date' => $this->date];
        $stock = factory(Stock::class)->states('EUR')->create();

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($this->date, 20, 'EUR'));

        $this->expectException(RiskServiceException::class);
        $this->stockRisk->instrumentDelta($stock, $parameter);

    }

    public function test_instrumentDelta_returns_EUR_delta_for_EUR_stock()
    {
        $parameter = ['date' => $this->date];
        $asset = factory(Asset::class)->states('EUR')->create();

        $expect = [
            ['class' => Stock::class, 'id' => $asset->positionable->id, 'value' => 1],
        ];

        $this->assertEquals($expect, $this->stockRisk->instrumentDelta($asset, $parameter));
    }


    public function test_instrumentDelta_returns_EUR_delta_for_USD_stock()
    {
        $parameter = ['date' => $this->date];
        $asset = factory(Asset::class)->states('USD')->create();

        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($this->date, 20, 'EUR'));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($this->date, 1.2, 'EUR'));

        $this->assertEquals([
            ['class' => Stock::class, 'id' => $asset->positionable->id, 'value' => 1.2],
            ['class' => Currency::class, 'id' => $asset->positionable->currency->id, 'value' => 20],
        ], $this->stockRisk->instrumentDelta($asset->positionable, $parameter));
    }


}
