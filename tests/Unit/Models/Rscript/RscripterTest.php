<?php

namespace Tests\Unit\Models\Rscript;

use App\Entities\Portfolio;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Rscript\Portfolio as Rscripter;


class RscripterTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->rscripter = new Rscripter(factory(Portfolio::class)->make());
    }

    /** @test */
    public function implode_is_a_valid_arg_string()
    {
        $args = ['task' => 'test-in-out', 'period' => 1];
        $argsString = $this->rscripter->argsImplode($args);

        $this->assertEquals('--task=test-in-out --period=1', $argsString);
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
}
