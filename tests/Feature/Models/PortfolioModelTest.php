<?php

namespace Tests\Feature\Models;

use App\Entities\Asset;
use App\Entities\Payment;
use App\Entities\Portfolio;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PortfolioModelTest extends TestCase
{
    use RefreshDatabase;

    private $portfolio;


    public function setUp()
    {
        parent::setUp();

        $this->portfolio = factory(Portfolio::class)->states('EUR')->create();
    }


    public function test_it_obtains_an_asset()
    {
        $asset = factory(Asset::class)->create();
        $this->portfolio->obtain($asset);

        $this->assertEquals($asset->id, $this->portfolio->assets->first()->id);
    }

    /**
     * @throws \Exception
     */
    public function test_receive_the_balance_at_a_date()
    {
        factory(Payment::class, 3)->create([
            'portfolio_id' => $this->portfolio->id,
            'type' => 'settlement',
            'amount' => 10.1,
            'executed_at' => '2017-12-20'
        ]);

        factory(Payment::class, 2)->create([
            'portfolio_id' => $this->portfolio->id,
            'type' => 'settlement',
            'amount' => -5.2,
            'executed_at' => '2017-12-22'
        ]);

        $this->assertEquals(0, $this->portfolio->balance( '2017-12-19'));
        $this->assertEquals(30.3, $this->portfolio->balance('2017-12-20'));
        $this->assertEquals(19.9, $this->portfolio->balance( '2017-12-22'));
        $this->assertEquals(19.9, $this->portfolio->balance());


    }
}
