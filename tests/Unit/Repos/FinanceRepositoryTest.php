<?php

namespace Tests\Unit\Repos;

use App\Entities\CcyPair;
use App\Entities\Currency;
use App\Repositories\FinanceRepository;
use App\Repositories\Metadata\QuandlECB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FinanceRepositoryTest extends TestCase
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
        $repo = new FinanceRepository();

        $this->assertEquals(250, count($repo->ccyHistory('EUR', 'USD')));
    }


    public function test_USDEUR_has_history()
    {
        $repo = new FinanceRepository();

        $this->assertEquals(250, count($repo->ccyHistory('USD', 'EUR')));
    }


    public function test_CZKUSD_has_history()
    {
        $repo = new FinanceRepository();

        $this->assertEquals(250, count($repo->ccyHistory('CZK', 'USD')));

    }

}
