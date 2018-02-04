<?php

namespace Tests\Feature\Services\RisksService;

use App\Classes\Output\Price;
use App\Entities\Stock;
use App\Facades\StockService;
use App\Services\RiskService\StockRisk;
use Tests\TestCase;

class StockRiskTest extends TestCase
{
    private $stockRisk;
    private $stock;
    private $date;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->stockRisk = new StockRisk();
        $this->date = '2017-12-29';
    }


    public function test_instrumentDelta_returns_two_dimensional_array_1()
    {
        $parameter = ['date' => $this->date];
        $stock = factory(Stock::class)->make();

        StockService::shouldReceive('priceAtDate')
            ->once()
            ->andReturn(new Price($this->date, 20, 'EUR'));

        $this->assertEquals(1,
            $this->stockRisk->instrumentDelta($stock, $parameter)
        );
    }

    public function test_instrumentDelta_returns_two_dimensional_array_2()
    {
        //
    }
}
