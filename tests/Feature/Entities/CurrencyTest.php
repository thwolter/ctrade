<?php

namespace Tests\Feature\Entities;

use App\Entities\Currency;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CurrencyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_currency_can_be_set_and_received()
    {
        factory(Currency::class)->create(['code' => 'EUR']);
        $code = Currency::where('code', 'EUR')->first()->code;

        $this->assertEquals('EUR', $code);
    }
    
    /** @test */
    public function can_receive_all_eligible_currencies()
    {
        factory(Currency::class)->create(['code' => 'EUR']);
        factory(Currency::class)->create(['code' => 'USD']);
        factory(Currency::class)->create(['code' => 'TRY', 'eligible' => false]);

        $this->assertEquals(['1' => 'EUR', '2' => 'USD'], Currency::eligible());
    }
}
