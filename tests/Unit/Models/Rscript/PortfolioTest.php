<?php

namespace Tests\Unit\Rscript;

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

    protected $rscripter;


    public function setUp()
    {
        parent::setUp();

        $this->rscripter = new Rscripter(factory(Portfolio::class)->make());

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

        $this->assertFileExists($this->rscripter->fullpath('portfolio.json'));
    }


    /** @test */
    public function implode_is_a_valid_arg_string()
    {
        $args = ['task' => 'test-in-out', 'period' => 1];
        $argsString = $this->rscripter->argsImplode($args);

        $this->assertEquals('--task=test-in-out --period=1', $argsString);
    }

    

}
