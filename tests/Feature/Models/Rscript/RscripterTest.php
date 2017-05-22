<?php

namespace Tests\Feature\Models\Rscript;

use App\Entities\Currency;
use App\Entities\Portfolio;
use App\Entities\Stock;
use App\Models\Exceptions\RscriptException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Rscript\Portfolio as Rscripter;


class RscripterTest extends TestCase
{

    use DatabaseMigrations;
    
    
    protected $rscripter;


    public function setUp()
    {
        parent::setUp();

        $currency = Currency::firstOrCreate(['code' => 'EUR']);
        $portfolio = factory(Portfolio::class)->create([
            'currency_id' => $currency->id
            ]);

        $this->rscripter = new Rscripter($portfolio);

    }


    /** @test */
     public function can_create_and_delete_a_tmp_directory()
     {
        $this->assertDirectoryExists(storage_path('app/'.$this->rscripter->path()));
        $this->assertDirectoryExists($this->rscripter->fullpath());

        $this->rscripter->deleteTempDir();
        $this->assertDirectoryNotExists($this->rscripter->fullpath());

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

        $this->rscripter->deleteTempDir();
    }


    /** @test */
    public function can_call_rscript_with_a_test_function()
    {
        $this->assertTrue(is_array($this->rscripter->callRscript()));
    }

    /** @test */
    public function an_invalid_rscript_call_throws_an_error()
    {
        $this->expectException(RscriptException::class);
        $this->rscripter->callRscript(['task' => 'a not defined task']);
    }
  
}
