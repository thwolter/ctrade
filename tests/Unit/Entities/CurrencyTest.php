<?php

namespace Tests\Unit\Entities;

use App\Entities\Currency;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CurrencyTest extends TestCase
{
    use DatabaseMigrations;

    protected $code = 'EUR';

    public function test_can_create_currency()
    {
        factory(Currency::class)->create(['code' => $this->code]);
        $code = Currency::where('code', $this->code)->first()->code;
        $this->assertEquals($this->code, $code);
    }
}
