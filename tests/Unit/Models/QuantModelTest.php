<?php

namespace Tests\Unit\Repos;

use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Models\QuantModel;
use App\Repositories\DataRepository;
use App\Repositories\Metadata\QuandlECB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuantModelTest extends TestCase
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
        $this->assertEquals(250, count(QuantModel::ccyHistory('EUR', 'USD')));
    }


    public function test_USDEUR_has_history()
    {
        $this->assertEquals(250, count(QuantModel::ccyHistory('USD', 'EUR')));
    }


    public function test_CZKUSD_has_history()
    {
        $this->assertEquals(250, count(QuantModel::ccyHistory('CZK', 'USD')));
    }

    public function test_CZKUSD_has_price()
    {
        $this->assertGreaterThan(0, count(QuantModel::ccyPrice('CZK', 'USD')));
    }
}
