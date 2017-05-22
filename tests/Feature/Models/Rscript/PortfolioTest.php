<?php

namespace Tests\Feature\Models\Rscript;

use App\Entities\Currency;
use App\Entities\Portfolio;
use App\Entities\Stock;
use App\Models\Pathway;
use App\Repositories\Metadata\QuandlECB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PortfolioTest extends TestCase
{

    use DatabaseMigrations;

    protected $portfolio;
    protected $stock;


    public function setUp()
    {
        parent::setUp();

        $currency = Currency::firstOrCreate(['code' => 'USD']);
        Currency::firstOrCreate(['code' => 'EUR']);

        QuandlECB::sync();

        $this->stock = Stock::saveWithParameter([
                  'name' => 'Allianz',
                  'currency' => 'EUR',
                  'sector' => 'Insurance'
              ]);
        Pathway::make('Quandl', 'SSE', 'ALV')->assign($this->stock);

        $this->portfolio = factory(Portfolio::class)->create([
            'currency_id' => $currency->id
        ]);

    }


    /** @test */
    public function an_empty_portfolio_has_no_history_files()
    {
        $this->portfolio->rscript()->storeHistoryFiles();
        $this->assertTrue(true);
    }


    /** @test */
    public function it_saves_a_portfolio_position_as_json()
    {
        $this->portfolio->obtain(10, $this->stock);
        $this->portfolio->rscript()->storeHistoryFiles();

        $this->assertFileExists($this->portfolio->rscript()->fullpath('Stock-1.json'));

    }


    //ToDo: Portfolio definieren, mit welchem gerechnet werden kann

    /** @test */
    public function a_risk_is_calculated()
    {
        $risk = $this->rscripter->risk(20, 0.95);
        $this->assertGreaterThan(20, $risk['Total'][0]['Value']);
        $this->assertLessThan(80, $risk['Total'][0]['Value']);

    }


    public function test_receive_historic_portfolio_values()
    {
        $valueHistory = $this->portfolio->rscript()->valueHistory(60);

        $this->assertEquals(60, count($valueHistory['History']));
    }


    public function test_summary_has_figures_and_history()
    {
        $summary = $this->portfolio->rscript()->summary();

        $this->assertArrayHasKey('Risks', $summary);
        $this->assertArrayHasKey('History', $summary);

        $this->assertGreaterThan(5, count($summary['History']));
    }

}
