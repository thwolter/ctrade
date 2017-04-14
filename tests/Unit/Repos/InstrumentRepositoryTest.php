<?php

namespace Tests\Unit;

use App\Repositories\InstrumentRepository as Instrument;
use App\Position;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InstrumentRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_position_is_created()
    {
        $this->createStock('ALV.DE', 'EUR');

        $this->assertDatabaseHas('stocks', ['symbol' => 'ALV.DE']);
    }


    private function createStock($symbol, $currency) {

        $portfolio = factory('App\Portfolio')->create();

        $instrument = Instrument::make('S')->firstOrCreate([
            'symbol'=> $symbol,
            'currency'=> $currency]);

        $position = new Position;
        $instrument->positions()->save($position);
        $portfolio->positions()->save($position);
    }

    public function test_stock_has_price() {

        $stock = $this->createStock('BAS.DE', 'EUR');

        $this->assertGreaterThan(0, $stock->price());
    }
}
