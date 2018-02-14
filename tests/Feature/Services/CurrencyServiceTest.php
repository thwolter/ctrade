<?php

namespace Tests\Feature\Services;

use App\Classes\TimeSeries;
use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Facades\CurrencyService;
use App\Facades\DataService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\FakeHistoryTrait;

class CurrencyServiceTest extends TestCase
{
    use FakeHistoryTrait;

    protected $timeSeries;


    public function setUp()
    {
        parent::setUp();
        $this->timeSeries = new TimeSeries($this->data, $this->columns);
    }


    /**
     * @throws \Exception
     */
    public function test_history_returns_rate_for_EURUSD()
    {
        $this->mockDataService();
        $this->assertEquals($this->timeSeries, CurrencyService::history('EUR', 'USD'));

        $this->mockDataService();
        $eur = Currency::whereCode('EUR')->first();
        $usd = Currency::whereCode('USD')->first();
        $this->assertEquals($this->timeSeries, CurrencyService::history($eur, $usd));

    }


    /**
     * @throws \Exception
     */
    public function test_history_returns_reciprocal_rate_for_USDEUR()
    {
        $this->mockDataService();

        $this->assertEquals($this->timeSeries->reciprocal(), CurrencyService::history('USD', 'EUR'));
    }


    /**
     * @throws \Exception
     */
    public function test_priceAt_returns_fxrate_for_given_date()
    {
        $this->mockDataService();

        CcyPair::firstOrCreate(['origin' => 'EUR', 'target' => 'USD']);

        $this->assertEquals($this->dataCloseAt27,
            CurrencyService::priceAt('EUR', 'USD', '2017-12-27')->getValue()
        );

        $this->mockDataService();

        $this->assertEquals(1/ $this->dataCloseAt27,
            CurrencyService::priceAt('USD', 'EUR', '2017-12-27')->getValue()
        );
    }


    private function mockDataService()
    {
        DataService::shouldReceive('history')
            ->once()
            ->andReturn($this->timeSeries);
    }
}
