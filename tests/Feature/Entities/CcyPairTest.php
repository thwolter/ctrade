<?php

namespace Tests\Feature\Entities;

use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Repositories\Metadata\QuandlECB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CcyPairTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        Currency::firstOrCreate(['code' => 'USD']);
        Currency::firstOrCreate(['code' => 'CZK']);

        QuandlECB::sync();

    }

    public function test_EURUSD_has_history()
    {
        $ccypair = CcyPair::whereOrigin('EUR')->whereTarget('USD')->first();

        $this->assertEquals(250, count($ccypair->history()));
    }


    public function test_EURUSD_has_price()
    {
        $ccypair = CcyPair::whereOrigin('EUR')->whereTarget('USD')->first();

        $this->assertGreaterThan(0, $ccypair->price());
    }
}
