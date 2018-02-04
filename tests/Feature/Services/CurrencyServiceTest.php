<?php

namespace Tests\Feature\Services;

use App\Facades\CurrencyService;
use App\Facades\DataService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyServiceTest extends TestCase
{
    public function test_price_returns_currency_fxrate()
    {
        //
    }


    public function test_priceAt_returns_fxrate_for_given_date()
    {
        DataService::shouldReceive('priceAt')
            ->once()
            ->andReturn(1.23);

        $this->assertEquals(1.23, CurrencyService::priceAt('EUR', 'USD', '2017-12-29'));
    }
}
