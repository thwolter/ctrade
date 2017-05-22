<?php

namespace Tests\Feature\Repos\Quandl;

use App\Models\Exceptions\PathwayException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Dataset;
use App\Entities\Stock;
use App\Models\Pathway;
use App\Repositories\Quandl\Quandldata;

class QuandldataTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
        
        $stock = Stock::saveWithParameter([
            'name' => 'Allianz',
            'currency' => 'EUR',
            'sector' => 'Industry'
        ]);
        Pathway::make('Quandl', 'SSE', 'ALV')->assign($stock);
    }


    /** @test */
    public function a_code_has_a_price()
    {
        $quandl = new Quandldata('ALV');

        $this->assertGreaterThan(0, Quandldata::getPrice('ALV'));
        $this->assertGreaterThan(0, $quandl->price());
    }

    /** @test */
    public function a_code_has_a_history()
    {
        $quandl = new Quandldata('ALV');

        $this->assertEquals(250, count(Quandldata::getHistory('ALV')));
        $this->assertEquals(250, count($quandl->history()));
    }

    /** @test */
    public function a_price_for_invalid_code_throws_an_error()
    {
        $this->expectException(PathwayException::class);
        Quandldata::getPrice('Fake');
    }


}
