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

    public function testExample()
    {

        $portfolio = factory('App\Portfolio')->create();

        $instrument = Instrument::make('S')->firstOrCreate([
            'symbol'=> 'BAS.DE',
            'currency'=> 'EUR']);

        $position = new Position;
        $instrument->positions()->save($position);
        $portfolio->positions()->save($position);

        $this->assertDatabaseHas('stocks', 'BAS.DE');
    }

}
