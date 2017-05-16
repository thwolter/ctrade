<?php

namespace Tests\Unit\Entities;

use App\Entities\CcyPair;
use App\Entities\Portfolio;
use App\Entities\Position;
use App\Entities\Stock;
use App\Entities\Currency;

use App\Models\Pathway;
use App\Repositories\Metadata\QuandlECB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;


class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

    protected $currency;
    protected $stock;
    protected $position;
    protected $portfolio;


    public function setUp()
    {
        parent::setUp();

        $this->currency = Currency::firstOrCreate(['code' => 'USD']);
        QuandlECB::sync();

        $this->stock = Stock::saveWithParameter([
            'name' => 'Allianz',
            'currency' => 'EUR',
            'sector' => 'Industry'
        ]);
        Pathway::make('Quandl', 'SSE', 'ALV')->assign($this->stock);

        $this->portfolio = factory(Portfolio::class)->create([
            'currency_id' => $this->currency->id
        ]);

        $this->position = factory(Position::class)->make([
            'positionable_id' => $this->stock->id,
            'positionable_type' => Stock::class,
            'amount' => 10
        ]);

        $this->portfolio->positions()->save($this->position);
    }

    public function test_portfolio_has_currency()
    {
        $this->assertEquals($this->currency->code, $this->portfolio->currency->code);
    }

    public function test_portfolio_total_for_ALV()
    {
        $rate = CcyPair::whereOrigin('EUR')->whereTarget('USD')->first()->price();

        $this->assertEquals(10 * $rate * $this->stock->price(), $this->portfolio->total());
    }


    public function test_can_make_array()
    {
        $array = $this->portfolio->toArray();

        $this->assertArrayHasKey('name', $array['item'][0]);
    }

    
    public function test_save_required_symbols()
    {
        $tmpdir = $this->tempDirectoroy();
        $this->portfolio->rscript()->saveSymbols($tmpdir);


        $this->assertTrue(Storage::disk('local')->exists("{$tmpdir}/pos-1.json"));
        $this->assertTrue(Storage::disk('local')->exists("{$tmpdir}/USDEUR.json"));

        Storage::deleteDirectory($tmpdir);
    }   
    
    
}
