<?php

namespace Tests\Unit;

use App\Repositories\Contracts\InstrumentInterface as Instrument;
use App\Position;
use Psr\Log\InvalidArgumentException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InstrumentRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {

        parent::setUp();

    }

    public function test_position_is_created()
    {
        $this->createStock('ALV.DE');

        $this->assertDatabaseHas('stocks', ['symbol' => 'ALV.DE']);
    }


    private function createStock($symbol) {

        $portfolio = factory('App\Portfolio')->create();

        $instrument = Instrument::make('Stock')->firstOrCreate(['symbol'=> $symbol]);

        $position = new Position;
        $instrument->positions()->save($position);
        $portfolio->positions()->save($position);

        return $instrument;
    }


    public function test_stock_has_price() {

        $stock = $this->createStock('BAS.DE');

        $this->assertGreaterThan(0, $stock->price());
    }

    public function test_stock_blade_equals_instrument_blade()
    {
        $stock = $this->createStock('BAS.DE');
        $this->assertStringStartsWith('instruments.stock', $stock->blade());
    }

    public function test_instrument_create_with_one_letter()
    {
        $instrument1 = Instrument::make('S')->firstOrCreate(['symbol'=> 'ALV.DE']);
        $instrument2 = Instrument::make('Stock')->firstOrCreate(['symbol'=> 'ALV.DE']);

        $this->assertEquals($instrument1->blade(), $instrument2->blade());
    }

    public function test_()
    {
        Instrument::make('Stock')->firstOrCreate(['symbol'=> 'DAI.DE']);

        $stock = Instrument::make('Stock')->with(['symbol' => 'DAI.DE']);

        $this->assertGreaterThan(0, $stock->price());
        $this->assertStringStartsWith('DAIMLER', $stock->name());


    }
}
