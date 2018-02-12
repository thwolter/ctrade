<?php

namespace Tests\Feature\Models;

use App\Entities\Payment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws \Exception
     */
    public function test_filter_one_payment_by_given_date()
    {
        factory(Payment::class)->create(['executed_at' => '2017-12-25']);

        $this->assertEquals(0, Payment::until('2017-12-24')->count());
        $this->assertEquals(1, Payment::until('2017-12-25')->count());
        $this->assertEquals(1, Payment::until('2017-12-26')->count());
    }

    /**
     * @throws \Exception
     */
    public function test_filter_many_payments_by_given_date()
    {
        factory(Payment::class, 1)->create(['executed_at' => '2017-12-24']);
        factory(Payment::class, 2)->create(['executed_at' => '2017-12-25']);
        factory(Payment::class, 3)->create(['executed_at' => '2017-12-26']);

        $this->assertEquals(1, Payment::until('2017-12-24')->count());
        $this->assertEquals(3, Payment::until('2017-12-25')->count());
        $this->assertEquals(6, Payment::until('2017-12-26')->count());
        $this->assertEquals(6, Payment::until('2017-12-26')->count());
    }

    /**
     * @throws \Exception'
     */
    public function test_filter_for_buy_or_sell_turnover()
    {
        factory(Payment::class, 2)->create(['type' => 'settlement']);
        factory(Payment::class, 5)->create(['type' => 'payment']);

        $this->assertEquals(2, Payment::ofType('settlement')->count());
        $this->assertEquals(5, Payment::ofType('payment')->count());
        $this->assertEquals(7, Payment::all()->count());
    }

}
