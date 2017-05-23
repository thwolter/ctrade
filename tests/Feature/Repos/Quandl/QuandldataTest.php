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

        $this->assertCount(250, Quandldata::getHistory('ALV'));
        $this->assertCount(250, $quandl->history());
        
    }

    /** @test */
    public function a_price_for_invalid_code_throws_an_error()
    {
        $this->expectException(PathwayException::class);
        Quandldata::getPrice('Fake');
    }

    
    /** @test */
    public function history_has_a_date_and_a_price_column()
    {
        $quandl = new Quandldata('ALV');
        $array = $quandl->history(['limit' => 5]);
        
        $this->assertTrue($this->validateDate($array[0]['Date']));
        $this->assertTrue(is_numeric($array[0]['Close']));
    }
    
    
    public function validateDate($date)
    {
        $d = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
