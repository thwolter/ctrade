<?php

namespace Tests\Unit\Services;

use App\Facades\RiskService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RiskServiceTest extends TestCase
{

    public $stockA = [
        '2018-01-02' => 7.57,
        '2017-12-29' => 7.58,
        '2017-12-28' => 7.59,
        '2017-12-27' => 7.59,
        '2017-12-22' => 7.52
    ];

    public $stockB = [
        '2018-01-02' => 29.5,
        '2017-12-29' => 30,
        '2017-12-28' => 30.75,
        '2017-12-27' => 30.15,
        '2017-12-22' => 30.14
    ];

    public $shares = [
        'stockA' => 100,
        'stockB' => 7
    ];

    public $VaR = [
        'stockA' => 2.7249,         // contribution 95
        'stockB' => 6.3726,         // contribution 95
        'portfolio' => 9.0975       // confidence 95
    ];



    public function test_can_calculate_singleVaR()
    {
        $this->assertEquals(0, RiskService::singleVaR([10,10,10], 0.95, 1));

        $this->assertEquals(1.4095928624249823, RiskService::singleVaR([12, 5, 7], 0.95, 1));
    }

}
