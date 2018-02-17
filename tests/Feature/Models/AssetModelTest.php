<?php

namespace Tests\Feature\Models;

use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Portfolio;
use App\Entities\Position;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\FakeAssetsTrait;

/**
 * Class AssetModelTest
 * @package Tests\Feature\Models
 */
class AssetModelTest extends TestCase
{
    use RefreshDatabase;
    use FakeAssetsTrait;

    /**
     * @var array
     */
    private  $trades = [
        ['price' => 10, 'number' => 1, 'fxrate' => 1.5, 'type' => 'settlement', 'executed_at' => '2017-12-01'],
        ['price' => 20, 'number' => 2, 'fxrate' => 2, 'type' => 'settlement', 'executed_at' => '2017-12-05'],
        ['price' => 15, 'number' => -1, 'fxrate' => 2, 'type' => 'settlement', 'executed_at' => '2017-12-10'],
        ['price' => 18, 'number' => -2, 'fxrate' => 1, 'type' => 'settlement', 'executed_at' => '2017-12-15'],
    ];


    /**
     * @throws \Exception
     */
    public function test_can_obtain_positions()
    {
        $asset = factory(Asset::class)->create();
        $position = $this->createPosition();

        $asset->obtain($position);
        $this->assertEquals(1, $asset->positions->count());
        $this->assertEquals($position->id, $asset->positions->first()->id);


        $asset->obtain($this->createPosition());
        $asset->refresh();
        $this->assertEquals(2, $asset->positions->count());
    }


    /**
     * @throws \Exception
     */
    public function test_it_returns_the_number_at_given_date()
    {
        $asset = $this->createAsset($this->trades);

        $this->assertEquals(0, $asset->numberAt('2017-11-30'));
        $this->assertEquals(1, $asset->numberAt('2017-12-01'));
        $this->assertEquals(3, $asset->numberAt('2017-12-06'));
        $this->assertEquals(2, $asset->numberAt('2017-12-10'));
        $this->assertEquals(2, $asset->numberAt('2017-12-12'));

        $this->assertEquals(0, $asset->numberAt('2017-12-16'));
        $this->assertEquals(0, $asset->numberAt());
    }


    /**
     * @throws \Exception
     */
    public function test_it_has_property_number_with_current_number()
    {
        $asset = $this->createAsset($this->trades);
        $this->assertEquals(0, $asset->number);
    }


    /**
     * @throws \Exception
     */
    public function test_hasForeignCurrency_returns_true_for_foreign_currency()
    {
        $portfolio = factory(Portfolio::class)->states('USD')->create();
        $asset = factory(Asset::class)->states('EUR')->create();

        $portfolio->obtain($asset);
        $this->assertTrue($asset->hasForeignCurrency());
    }


    /**
     * @throws \Exception
     */
    public function test_hasForeignCurrency_returns_false_for_domestic_currency()
    {
        $portfolio = factory(Portfolio::class)->states('EUR')->create();
        $asset = factory(Asset::class)->states('EUR')->create();

        $portfolio->obtain($asset);
        $this->assertFalse($asset->hasForeignCurrency());
    }


    /**
     * @throws \Exception
     */
    public function test_return_payments_through_positions()
    {
        $payments = factory(Payment::class, 3)->create([
            'position_id' => factory(Position::class)->create()
        ]);

        $asset = $payments->first()->position->asset;
        $this->assertEquals($payments->sum('amount'), $asset->payments->sum('amount'));
    }


    /**
     * @throws \Exception
     */
    public function test_receive_settlement_amount()
    {
        $asset = $this->createAsset($this->trades, false);

        $this->assertEquals(10, $asset->settlement('2017-12-01'));
        $this->assertEquals(50, $asset->settlement('2017-12-05'));
        $this->assertEquals(35, $asset->settlement('2017-12-10'));
        $this->assertEquals(-1, $asset->settlement('2017-12-15'));
        $this->assertEquals(-1, $asset->settlement());
    }


    /**
     * @throws \Exception
     */
    public function test_receive_converted_settlement_amount()
    {
        $asset = $this->createAsset($this->trades, false);

        $this->assertEquals(15, $asset->convertedSettlement('2017-12-01'));
        $this->assertEquals(95, $asset->convertedSettlement('2017-12-05'));
        $this->assertEquals(65, $asset->convertedSettlement('2017-12-10'));
        $this->assertEquals(29, $asset->convertedSettlement('2017-12-15'));
        $this->assertEquals(29, $asset->convertedSettlement());
    }


    /**
     * @throws \Exception
     */
    public function test_receive_cost_value()
    {
        $asset = $this->createAsset($this->trades);

        $this->assertEquals(50/3, $asset->costValue('2017-12-06'));
        $this->assertEquals(17.5, $asset->costValue('2017-12-10'));
    }
}
