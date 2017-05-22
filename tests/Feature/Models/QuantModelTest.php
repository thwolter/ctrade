<?php

namespace Tests\Feature\Repos;

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
    /** @test */
    public function EURUSD_has_history()
    {
        $this->assertEquals(250, count(QuantModel::ccyHistory('EUR', 'USD')));
    }

    /** @test */
    public function USDEUR_has_history()
    {
        $this->assertEquals(250, count(QuantModel::ccyHistory('USD', 'EUR')));
    }

    /** @test */
    public function CZKUSD_has_history()
    {
        $this->assertEquals(250, count(QuantModel::ccyHistory('CZK', 'USD')));
    }

    /** @test */
    public function USDCZK_has_history()
    {
        $this->assertEquals(250, count(QuantModel::ccyHistory('USD', 'CZK')));
    }

    /** @test */
    public function CZKUSD_has_price()
    {
        $this->assertGreaterThan(0, count(QuantModel::ccyPrice('CZK', 'USD')));
    }

    /** @test */
    public function EUREUR_has_history_of_1()
    {
        $this->assertGreaterThan(0, count(QuantModel::ccyPrice('EUR', 'EUR')));

    }
}
