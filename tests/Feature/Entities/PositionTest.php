<?php

namespace Tests\Unit;

use App\Entities\CcyPair;
use App\Entities\Position;
use App\Entities\Stock;
use App\Entities\Portfolio;
use App\Entities\Currency;
use App\Models\QuantModel;
use App\Facades\Datasource;
use App\Repositories\Metadata\QuandlECB;
use App\Repositories\Quandl\Quandldata;
use App\Repositories\Yahoo\CurrencyFinancial;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionTest extends TestCase
{
    protected $position;

    use DatabaseMigrations;


    public function setUp()
    {
        parent::setUp();

        $this->position = $this->makePositionWithStock('ALV', 'Allianz');

        Currency::firstOrCreate(['code' => 'USD']);
        QuandlECB::sync();

    }

    /** @test */
    public function positions_has_a_currency()
    {
        $this->assertEquals('EUR', $this->position->currency()->code);
        $this->assertEquals('EUR', $this->position->currency->code);
    }

    /** @test */
    public function position_has_a_price()
    {
        $price = array_first(Quandldata::getPrice('ALV'));

        $this->assertEquals($price, $this->position->price());
    }


    public function test_position_stock_has_name()
    {
        $this->assertEquals('Allianz', $this->position->name());
    }

    public function test_position_has_amount()
    {
        $this->assertGreaterThan(0, $this->position->amount());
    }

    public function test_position_has_total()
    {
        $this->assertGreaterThan(0, $this->position->total());
    }

    
    public function test_total_with_currency_converts_into_this_currency() {
        
        $rate = array_first(CcyPair::whereOrigin('EUR')->whereTarget('USD')->first()->price());
      
        $this->assertEquals($this->position->total() * $rate, $this->position->total('USD'));
        
    }

    public function test_position_total_value_in_original_currency()
    {
        $this->assertEquals(5 * $this->position->price(), $this->position->total());
    }


    public function test_position_total_value_in_portfolio_currency()
    {
        $rate = array_first(QuantModel::ccyPrice('EUR', 'USD'));

        $expect = 5 * $this->position->price() * $rate;

        $this->assertEquals($expect, $this->position->total('USD'));
    }


    //Todo: implement new currency data source
    public function test_method_currency_give_position_currency()
    {
        $this->assertEquals('EUR', $this->position->currency()->code);
    }


    public function test_typeDisp_of_stock_shows_Aktie()
    {
        $this->assertEquals('Aktie', $this->position->typeDisp());
    }

    public function test_can_create_an_array()
    {
        $array = $this->position->toArray();

        $this->assertArrayHasKey('name', $array);
        $this->assertEquals('Allianz', $array['name']);
    }

    public function test_position_has_history()
    {

        $data = $this->position->history();

        $this->assertTrue(is_array($data));
    }


    /** @test */
    public function position_has_a_currency_code()
    {
        $this->assertEquals('EUR', $this->position->currency->code);
    }

    /** @test */
    public function different_positions_have_different_prices()
    {
        $priceBAS = $this->makePositionWithStock('BAS', 'Basf')->price();
        $priceDAI = $this->makePositionWithStock('DAI', 'Daimler')->price();

        $this->assertNotEquals($priceBAS, $priceDAI);
    }


    public function makePositionWithStock($datasetCode, $name)
    {
        $stock = Stock::saveWithParameter([
            'name' => $name,
            'currency' => 'EUR',
            'sector' => 'Industry'
        ]);
        Datasource::make('Quandl', 'SSE', $datasetCode)->assign($stock);

        $position = factory(Position::class)->create([
            'positionable_id' => $stock->id,
            'positionable_type' => Stock::class,
            'amount' => 5
        ]);

        return $position;
    }
}
