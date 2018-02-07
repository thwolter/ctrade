<?php

namespace Tests\Feature\Services;

use App\Classes\TimeSeries;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Facades\RiskService\RiskService;
use Tests\TestCase;
use Tests\Traits\FakeHistoryTrait;

class RiskServiceTest extends TestCase
{

    use FakeHistoryTrait;


    private $stock;
    private $parameter;


    public function setUp()
    {
        parent::setUp();

        $this->stock = Stock::find(1);
        $this->parameter = ['period' => 20, 'confidence' => 0.95, 'count' => 20];
    }


    /**
     * @expectedException \App\Exceptions\RiskServiceException
     */
    public function test_instrumentVaR_throws_error_when_missing_parameter()
    {
        RiskService::instrumentVaR($this->stock, []);
    }



}
