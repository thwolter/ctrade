<?php

namespace Tests\Feature\Models;

use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Portfolio;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\FakeAssetsTrait;

class PortfolioModelTest extends TestCase
{
    use RefreshDatabase;
    use FakeAssetsTrait;

    private $portfolio;

    private  $payments = [
        ['type' => 'settlement', 'amount' => -1, 'executed_at' => '2017-12-01'],
        ['type' => 'settlement', 'amount' => -2, 'executed_at' => '2017-12-05'],
        ['type' => 'settlement', 'amount' => -4, 'executed_at' => '2017-12-10'],
        ['type' => 'settlement', 'amount' => 8, 'executed_at' => '2017-12-15'],
        ['type' => 'payment', 'amount' => 400, 'executed_at' => '2017-12-20'],
        ['type' => 'payment', 'amount' => -300, 'executed_at' => '2017-12-22'],
    ];


    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->create();

        foreach ($this->payments as $payment) {
            $this->portfolio->payments()->create($payment);
        }
    }


    /**
     * @throws \Exception
     */
    public function test_it_obtains_an_asset()
    {
        $asset = factory(Asset::class)->create();
        $portfolio = factory(Portfolio::class)->create();

        $portfolio->obtain($asset);

        $this->assertEquals($asset->id, $portfolio->assets->first()->id);
    }

    /**
     * @throws \Exception
     */
    public function test_receive_the_balance_at_a_date()
    {
        $this->assertEquals(6, $this->portfolio->payments->count());
        $this->assertEquals(-1, $this->portfolio->balance( '2017-12-01'));
        $this->assertEquals(-3, $this->portfolio->balance('2017-12-05'));
        $this->assertEquals(-7, $this->portfolio->balance( '2017-12-10'));
        $this->assertEquals(1, $this->portfolio->balance( '2017-12-15'));
        $this->assertEquals(401, $this->portfolio->balance('2017-12-20'));
        $this->assertEquals(101, $this->portfolio->balance());
    }
}
