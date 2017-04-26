<?php

namespace Tests\Unit\Rscript;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;


class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

    protected $portfolio;

    public function setUp()
    {
        parent::setUp();
        $this->portfolio = $this->makePortfolio('EUR');
    }

    public function test_can_save_json()
    {
        $tmpdir = $this->tempDirectoroy();
        $filename = $tmpdir.'/test.json';

        $this->portfolio->rscript()->saveJSON($filename);

        $this->assertTrue(Storage::disk('local')->exists($filename));
        Storage::deleteDirectory($tmpdir);
    }

    public function test_rscript_can_read_and_write_file()
    {
        $result = $this->portfolio->rscript()->callRscript(['task' => 'test-in-out']);
        $this->assertEquals($this->portfolio->cash(), $result['cash']['amount']);
    }

    public function test_calculated_risk()
    {
        $risk = $this->portfolio->rscript()->risk(20, 0.95);
       
        $this->assertGreaterThan(20, $risk['Portfolio']);
        $this->assertLessThan(80, $risk['Portfolio']);

    }

    public function test_implode_is_valid_arg_string()
    {
        $args = ['task' => 'test-in-out', 'period' => 1];
        $argsString = $this->portfolio->rscript()->argsImplode($args);
        $this->assertEquals('--task=test-in-out --period=1', $argsString);
    }


}
