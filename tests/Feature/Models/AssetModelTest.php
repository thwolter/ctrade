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
        ['price' => 10, 'amount' => 1, 'executed_at' => '2017-12-01'],
        ['price' => 20, 'amount' => 2, 'executed_at' => '2017-12-05'],
        ['price' => 15, 'amount' => -1, 'executed_at' => '2017-12-10'],
        ['price' => 18, 'amount' => -2, 'executed_at' => '2017-12-15'],
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
    public function test_it_returns_the_amount_at_given_date()
    {
        $asset = $this->domesticAssetWithTrades($this->trades);

        $this->assertEquals(0, $asset->amountAt('2017-11-30'));
        $this->assertEquals(1, $asset->amountAt('2017-12-01'));
        $this->assertEquals(3, $asset->amountAt('2017-12-06'));
        $this->assertEquals(2, $asset->amountAt('2017-12-10'));
        $this->assertEquals(2, $asset->amountAt('2017-12-12'));

        $this->assertEquals(0, $asset->amountAt('2017-12-16'));
        $this->assertEquals(0, $asset->amountAt(Carbon::now()->toDateString()));
    }


    /**
     * @throws \Exception
     */
    public function test_it_has_property_amount_with_current_amount()
    {
        $trades = array_push($this->trades,
            ['price' => 12, 'amount' => 5, 'executed_at' => '2017-12-20']
        );

        $asset = $this->domesticAssetWithTrades($this->trades);
        $this->assertEquals(5, $asset->amount);
    }

    /**
     * @throws \Exception
     */
    public function test_returns_true_for_foreign_currency()
    {
        $portfolio = factory(Portfolio::class)->states('USD')->create();
        $asset = factory(Asset::class)->states('EUR')->create();

        $portfolio->obtain($asset);
        $this->assertTrue($asset->hasForeignCurrency());
    }


    /**
     * @throws \Exception
     */
    public function test_returns_false_for_domestic_currency()
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

    public function test_receive_settlement_amount()
    {
        $asset = factory(Asset::class)->create();

        $position = factory(Position::class)->create();

        $asset->obtain($position);

        $position->payments()
            ->create([
                'amount' => 10,
                'type' => 'settlement',
                'price' => 15
            ]);





        $this->assertEquals(0, $asset->settled('2017-12-24'));
    }
}
