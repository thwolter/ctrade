<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\FinancialRepository;

class FinancialRepositoryTest extends TestCase
{

    protected $stock;
    protected $fx;

    public function setUp()
    {
        parent::setUp();

        $this->stock = new FinancialRepository('Stock',['symbol' => 'ALV.DE']);
        $this->fx = new FinancialRepository('Fx',['symbol' => 'EURUSD']);
    }

    public function test_make_FinancialRepository()
    {
        $stock = FinancialRepository::make('Stock',['symbol' => 'ALV.DE']);
        $this->assertInstanceOf('App\Repositories\FinancialRepository', $stock);
    }


    public function test_stock_price_is_positive_number()
    {
        $this->assertGreaterThan(0, $this->stock->price);
    }

    public function test_stock_name_starts_with_Allianz()
    {

        $this->assertStringStartsWith('ALLIANZ', $this->stock->name);
    }

    public function test_fx_price_is_positive_number()
    {
        $this->assertGreaterThan(0, $this->fx->price);
    }

    public function test_fx_name_starts_with_EURUSD()
    {

        $this->assertStringStartsWith('EURUSD', $this->fx->name);
    }

}
