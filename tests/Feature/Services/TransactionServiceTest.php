<?php

namespace Tests\Feature\Services;

use App\Entities\Portfolio;
use App\Entities\Stock;
use App\Facades\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;


    private $trade = [
        'price' => 10,
        'number' => 2,
        'fxrate' => 1,
        'transaction' => 'settlement',
        'executed' => '2017-12-01',
        'instrumentType' => Stock::class,
        'instrumentId' => 256,
        'amount' => 20,
        'fee' => 14
    ];

    private $portfolio;


    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->create();
    }

    /**
     * @throws \Exception
     */
    public function test_can_persist_a_trade()
    {
        TransactionService::trade($this->portfolio, $this->trade);

        $this->assertDatabaseHas('positions', ['price' => 10, 'number' => 2, 'fxrate' => 1]);
        $this->assertDatabaseHas('payments', ['type' => 'settlement']);
        $this->assertDatabaseHas('payments', ['type' => 'fee']);

        $this->assertEquals(-34, $this->portfolio->balance());
    }


    /**
     * @throws \Exception
     */
    public function test_can_deposit_an_amount()
    {
        $payment = ['amount' => 100, 'date' => '2017-12-20'];

        TransactionService::deposit($this->portfolio, $payment);

        $this->assertDatabaseHas('payments', ['type' => 'payment']);
        $this->assertEquals(100, $this->portfolio->balance());
    }


    /**
     * @throws \Exception
     */
    public function test_can_withdraw_an_amount()
    {
        $payment = ['amount' => -400, 'date' => '2017-12-20'];

        TransactionService::deposit($this->portfolio, $payment);

        $this->assertDatabaseHas('payments', ['type' => 'payment']);
        $this->assertEquals(-400, $this->portfolio->balance());
    }
}
