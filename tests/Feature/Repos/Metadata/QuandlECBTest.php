<?php

namespace Tests\Feature\Repos\Metadata;

use App\Entities\Currency;
use App\Entities\Datasource;
use App\Repositories\Metadata\QuandlECB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QuandlECBTest extends TestCase
{

    use DatabaseMigrations;

    protected $meta;


    public function setUp()
    {
        parent::setUp();

        $this->meta = new QuandlECB();
        Currency::firstOrCreate(['code' => 'EUR']);
        Currency::firstOrCreate(['code' => 'USD']);
    }

    public function test_can_assign_list_of_currencies()
    {
        $currency = Currency::firstOrCreate(['code' => 'CZK']);

        $this->meta->load();
        $provider = Datasource::withDataset('EURCZK')->first()->provider;

        $this->assertEquals('Quandl', $provider->code);
    }

    public function test_can_call_with_static_sync()
    {
        QuandlECB::sync();
        $provider = Datasource::withDataset('EURUSD')->first()->provider;

        $this->assertEquals('Quandl', $provider->code);

    }
}
