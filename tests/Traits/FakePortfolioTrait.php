<?php

namespace Tests\Traits;


use App\Entities\Asset;
use App\Entities\Currency;
use App\Entities\Portfolio;
use App\Entities\Position;
use Illuminate\Foundation\Testing\WithFaker;


trait FakePortfolioTrait
{
    use WithFaker;


    public function domesticPortfolio()
    {
        $portfolio = factory(Portfolio::class)->states('EUR')->create();

        $assets = factory(Asset::class, $this->faker->numberBetween(1, 5))
            ->states('EUR')
            ->create();

        foreach ($assets as $asset) {
            $positions = factory(Position::class, $this->faker->numberBetween(2, 6))
                ->states('EUR')
                ->create();

            foreach ($positions as $position) {
                $position->fxrate = 1;
                $asset->obtain($position);
            }

            $portfolio->obtain($asset);
        }

       return $portfolio;
    }

}