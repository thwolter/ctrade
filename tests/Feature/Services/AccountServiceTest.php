<?php

namespace Tests\Feature\Services;

use App\Classes\Output\Price;
use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Portfolio;
use App\Entities\Position;
use App\Facades\AccountService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountServiceTest extends TestCase
{
    private $portfolio;

    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->create();
    }

    /**
     * @throws \Exception
     */
    public function test_returns_the_current_account_balance_for_given_portfolio()
    {
        $payments = factory(Payment::class, 3)->create([
            'portfolio_id' => $this->portfolio->id,
            'type' => 'settlement',
            'amount' => 10.1,
            'executed_at' => '2017-12-20'
        ]);

        $payments = factory(Payment::class, 2)->create([
            'portfolio_id' => $this->portfolio->id,
            'type' => 'settlement',
            'amount' => -5.2,
            'executed_at' => '2017-12-22'
        ]);

        $expect = new Price('2017-12-20', 30.3, $this->portfolio->currency->code);
        $this->assertEquals($expect, AccountService::portfolioBalance($this->portfolio, '2017-12-20'));

        $expect = new Price('2017-12-22', 19.9, $this->portfolio->currency->code);
        $this->assertEquals($expect, AccountService::portfolioBalance($this->portfolio, '2017-12-22'));

        $this->assertEquals(0, AccountService::portfolioBalance($this->portfolio, '2017-12-19')->value);
    }

    /**
     * @throws \Exception
     */
    public function test_returns_turnover_for_an_asset_at_given_asset()
    {
        $position = factory(Position::class)->create([
            'asset_id' => factory(Asset::class)->create()
        ]);

        $payments = factory(Payment::class)->create([
            'portfolio_id' => $this->portfolio->id,
            'position_id' => $position->id,
            'type' => 'settlement',
            'amount' => 10,
            'executed_at' => '2017-12-20'
        ]);

        $payments = factory(Payment::class)->create([
            'portfolio_id' => $this->portfolio->id,
            'position_id' => $position->id,
            'type' => 'settlement',
            'amount' => 5,
            'executed_at' => '2017-12-22'
        ]);

        $expect = new Price('2017-12-20', 0, $this->portfolio->currency->code);
        $this->assertEquals($expect, AccountService::assetBalance($position->asset, '2017-12-18'));

        $expect = new Price('2017-12-20', 10, $this->portfolio->currency->code);
        $this->assertEquals($expect, AccountService::assetBalance($position->asset, '2017-12-20'));

        $expect = new Price('2017-12-22', 5, $this->portfolio->currency->code);
        $this->assertEquals($expect, AccountService::assetBalance($position->asset, '2017-12-22'));

        $expect = new Price('2017-12-25', 5, $this->portfolio->currency->code);
        $this->assertEquals($expect, AccountService::assetBalance($position->asset, '2017-12-25'));
    }
}
