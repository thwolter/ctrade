<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionTest extends TestCase
{
    protected $portfolio;

    public function setUp()
    {
        parent::setUp();
        //$this->portfolio->factory('App\Portfolio');
    }


    public function test_can_create_position_for_portfolio()
    {
        // take a type and symbol

        // create instance of position with type and symbol

        // check if position is available in database
    }
}
