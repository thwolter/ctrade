<?php

namespace Tests\Feature\Models;

use App\Entities\Payment;
use App\Entities\Position;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\FakeAssetsTrait;

class PositionModelTest extends TestCase
{
    use RefreshDatabase;
    use FakeAssetsTrait;

    private $trades = [
        ['price' => 10, 'number' => 1, 'fxrate' => 1.5, 'executed_at' => '2017-12-01'],
        ['price' => 20, 'number' => 2, 'fxrate' => 1, 'executed_at' => '2017-12-05'],
        ['price' => 15, 'number' => -1, 'fxrate' => 2, 'executed_at' => '2017-12-10'],
        ['price' => 18, 'number' => -2, 'fxrate' => 1, 'executed_at' => '2017-12-15'],
    ];

    /**
     * @throws \Exception
     */
    public function test_can_receive_positions_executed_before_a_given_date()
    {
        $asset = $this->domesticAssetWithTrades($this->trades);

        $this->assertEquals(0, $asset->positions()->until('2017-11-20')->count());
        $this->assertEquals(1, $asset->positions()->until('2017-12-01')->count());
        $this->assertEquals(4, $asset->positions()->until('2017-12-16')->count());

        $positions = $asset->positions()->until('2017-12-05')->get();

        $this->assertEquals(10, $positions->first()->price);
        $this->assertEquals(20, $positions->last()->price);
    }

    /**
     * @throws \Exception
     */
    public function test_can_obtain_a_payment()
    {
        $position = factory(Position::class)->create();
        $payment = factory(Payment::class)->make();

        $this->assertIsClass(Payment::class, $position->obtain($payment, 'Xetra'));
        $this->assertDatabaseHas('payments', ['amount' => $payment->amount]);
        $this->assertEquals('Xetra', $position->payments->first()->exchange->code);
    }

    /**
     * @throws \Exception
     */
    public function test_it_returns_the_positions_total()
    {
        $position = factory(Position::class)->create();

        $this->assertEquals($position->price * $position->number, $position->total);
        $this->assertEquals($position->price * $position->number * $position->fxrate, $position->convertedTotal);
    }
}
