<?php

namespace Tests\Unit\Repos;

use App\Repositories\PortfolioFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PortfolioFinancialTest extends TestCase
{

    protected $financial;

    public function setUp()
    {
        parent::setUp();

        $this->financial = new PortfolioFinancial;
    }

    public function test_has_history_as_json()
    {
        $json = $this->financial->history('EURUSD');

        $this->assertTrue(is_string($json) and is_array(json_decode($json, true)));
    }
}
