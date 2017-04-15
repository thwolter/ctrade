<?php

namespace Tests\Unit\Controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory('App\Portfolio')->create();
        $this->user = $this->portfolio->user;
    }

    public function testExample()
    {
        $position = factory('App\Position')->create();

        $this->stringStartsWith('EUR', $position->instrument->currency());
    }
}
