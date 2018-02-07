<?php

namespace Tests\Feature\Services\RisksService;

use App\Classes\Output\Price;
use App\Entities\Currency;
use App\Entities\Stock;
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


    public function test_instrumentDelta_returns_two_dimensional_array()
    {
        $parameter = ['date' => $this->date];

        $currency = Currency::make(['code' => 'USD']);

        $stock = factory(Stock::class)->make()
            ->currency()->associate($currency);


        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($this->date, 20, 'EUR'));

        CurrencyService::shouldReceive('priceAt')
            ->once()
            ->andReturn(new Price($this->date, 1.2, 'EUR'));

        $this->assertEquals([
            ['class' => Stock::class, 'id' => $stock->id, 'value' => 1.2],
            ['class' => Currency::class, 'id' => $currency->id, 'value' => 20],
        ], $this->stockRisk->instrumentDelta($stock, $parameter));
    }


}
