<?php

namespace Tests\Feature\Models;

use App\Entities\Asset;
use App\Entities\Portfolio;
use App\Entities\Position;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetModelTest extends TestCase
{
    use RefreshDatabase;


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


    public function test_it_returns_the_amount_at_given_date()
    {
        $asset = factory(Asset::class)->states('EUR')->create();

        $trades = [
            ['price' => 10, 'amount' => 1, 'executed_at' => '2017-12-01'],
            ['price' => 20, 'amount' => 2, 'executed_at' => '2017-12-05'],
            ['price' => 15, 'amount' => -1, 'executed_at' => '2017-12-10'],
            ['price' => 18, 'amount' => -2, 'executed_at' => '2017-12-15'],
        ];

        foreach ($trades as $trade) {
            $asset->obtain($this->createPosition($trade));
        }

        $this->assertEquals(0, $asset->amountAt('2017-11-30'));
        $this->assertEquals(1, $asset->amountAt('2017-12-01'));
        $this->assertEquals(3, $asset->amountAt('2017-12-06'));
        $this->assertEquals(2, $asset->amountAt('2017-12-12'));
        $this->assertEquals(0, $asset->amountAt('2017-12-16'));
        $this->assertEquals(0, $asset->amountAt(Carbon::now()->toDateString()));
    }


    public function test_returns_true_for_foreign_currency()
    {
        $portfolio = factory(Portfolio::class)->states('USD')->create();
        $asset = factory(Asset::class)->states('EUR')->create();

        $portfolio->obtain($asset);
        $this->assertTrue($asset->hasForeignCurrency());
    }


    public function test_returns_false_for_domestic_currency()
    {
        $portfolio = factory(Portfolio::class)->states('EUR')->create();
        $asset = factory(Asset::class)->states('EUR')->create();

        $portfolio->obtain($asset);
        $this->assertFalse($asset->hasForeignCurrency());
    }

    /**
     * @return mixed
     */
    private function createPosition($array = [])
    {
        $position = factory(Position::class)->create();
        $position->update($array);

        return $position;
    }
}
