<?php

namespace Tests\Feature\Services;

use App\Classes\DataProvider\QuandlPriceData;
use App\Classes\Output\Price;
use App\Classes\TimeSeries;
use App\Entities\CcyPair;
use App\Entities\Stock;
use App\Facades\DataService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\FakeHistoryTrait;

class DataServiceTest extends TestCase
{

    use FakeHistoryTrait;


    public function test_receive_stock_datasource()
    {
        $stock = Stock::find(1)->first();

        $this->assertEquals($stock->datasources->first()->id,
            DataService::getDatasource($stock, null)->id
        );

        $this->assertEquals(get_class($stock->datasources->first()),
            get_class(DataService::getDatasource($stock, null))
        );
    }


    public function test_receive_the_ccyPair_datasource()
    {
        $ccyPair = CcyPair::find(1)->first();

        $this->assertEquals($ccyPair->datasources->first()->id,
            DataService::getDatasource($ccyPair, null)->id
        );

        $this->assertEquals(get_class($ccyPair->datasources->first()),
            get_class(DataService::getDatasource($ccyPair, null))
        );
    }


    public function test_history_returns_a_stock_timeseries()
    {
        $history = DataService::history(Stock::find(1)->first());

        $this->assertEquals(TimeSeries::class, get_class($history));
        $this->assertGreaterThan(1, $history->count());
    }


    public function test_history_returns_a_ccyPair_timeseries()
    {
        $history = DataService::history(CcyPair::find(1)->first());

        $this->assertEquals(TimeSeries::class, get_class($history));
        $this->assertGreaterThan(1, $history->count());
    }


    public function test_price_returns_the_stock_price()
    {
        $price = DataService::price(Stock::find(1)->first());

        $this->assertEquals(Price::class, get_class($price));
        $this->assertGreaterThan(0, $price->getValue());
    }


    public function test_price_returns_the_ccyPair_price()
    {
        $price = DataService::price(CcyPair::find(1)->first());

        $this->assertEquals(Price::class, get_class($price));
        $this->assertGreaterThan(0, $price->getValue());
    }
}
