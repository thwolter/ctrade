<?php

namespace Tests\Feature\Services;

use App\Classes\TimeSeries;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Facades\RiskService\RiskService;
use Tests\TestCase;

class RiskServiceTest extends TestCase
{

    private $stock;
    private $parameter;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        //$this->stock = Stock::find(1);
        $this->parameter = ['period' => 20, 'confidence' => 0.95, 'count' => 20];

    }

    /**
     * @expectedException \App\Exceptions\RiskServiceException
     */
    public function test_instrumentVaR_throws_error_when_missing_parameter()
    {
        RiskService::instrumentVaR($this->stock, []);
    }

    public function testInstrumentVaR()
    {
        $parameter = ['period' => 20, 'confidence' => 0.95, 'count' => 20];

        DataService::shouldReceive('history')
            ->once()
            ->withArgs([
                'entity' => $this->stock,
                'exchange' => null
            ])
            ->andReturn($this->fakeHistory());

        $this->assertEquals(1, RiskService::instrumentVaR($this->stock, $this->parameter));
    }


    private function fakeHistory()
    {
        return new TimeSeries([
            ['2017-12-31', 40],
            ['2017-12-30', 40],
            ['2017-12-29', 40],
            ['2017-12-28', 40],
            ['2017-12-27', 40],

        ], ['Date', 'Close']);
    }
}
