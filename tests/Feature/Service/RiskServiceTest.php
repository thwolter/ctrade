<?php

namespace Tests\Feature\Service;

use App\Classes\TimeSeries;
use App\Entities\Stock;
use App\Facades\DataService;
use App\Facades\RiskService\RiskService;
use Tests\TestCase;

class RiskServiceTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @expectedException \App\Exceptions\RiskServiceException
     */
    public function testInstrumentVaRThrowsError()
    {
        RiskService::instrumentVaR(Stock::find(1), []);
    }

    public function testInstrumentVaR()
    {
        $entity = Stock::find(1);
        $parameter = ['period' => 20, 'confidence' => 0.95, 'count' => 20];

        DataService::shouldReceive('history')
            ->once()
            ->withArgs([
                'entity' => $entity,
                'exchange' => null
            ])
            ->andReturn($this->fakeHistory());

        $this->assertEquals(1, RiskService::instrumentVaR($entity, $parameter));
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
