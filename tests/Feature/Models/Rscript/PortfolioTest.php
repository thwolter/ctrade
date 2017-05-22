<?php

namespace Tests\Feature\Models\Rscript;

use App\Entities\Portfolio;
use App\Entities\Stock;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Rscript\Portfolio as Rscripter;


class PortfolioTest extends TestCase
{

    use DatabaseMigrations;
    
    
    protected $rscripter;


    public function setUp()
    {
        parent::setUp();

        $portfolio = factory(Portfolio::class)->create([
            'currency_id' => factory(Currency::class)->create(['code' => 'EUR'])->id
            ]);
        
        $this->rscripter = new Rscripter($portfolio);

    }


    /** @test */
     public function a_tmp_directory_is_created()
     {
        $this->assertDirectoryExists(storage_path('app/'.$this->rscripter->path()));
        $this->assertDirectoryExists($this->rscripter->fullpath());
     }


     /** @test */
      public function path_can_include_a_filename()
      {
         $this->assertEquals($this->rscripter->fullpath().'/test', $this->rscripter->fullpath('test'));
      }

    /** @test */
     public function it_has_an_entity_name()
     {
         $this->assertEquals('Portfolio', $this->rscripter->entityName());
     }


    /** @test */
    public function can_save_entity_as_json()
    {
        $portfolio = factory(Portfolio::class)->create();
        $portfolio
            ->obtain(10, factory(Stock::class)->create())
            ->obtain(20, factory(Stock::class)->create());


        $this->rscripter->saveJSON();
        $this->assertFileExists($this->rscripter->fullpath('Portfolio.json'));
    }


    /** @test */
    public function implode_is_a_valid_arg_string()
    {
        $args = ['task' => 'test-in-out', 'period' => 1];
        $argsString = $this->rscripter->argsImplode($args);

        $this->assertEquals('--task=test-in-out --period=1', $argsString);
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
