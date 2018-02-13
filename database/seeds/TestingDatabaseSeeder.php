<?php

use Illuminate\Database\Seeder;
use App\Models\Pathway;
use App\Entities\Currency;
use App\Entities\Stock;
use App\Entities\User;
use App\Entities\Portfolio;
use App\Entities\Position;


class TestingDatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(StockSeeder::class);

        // a user
        $user = factory(User::class)->create();

        // create two portfolios and assign to user
        $portfolioEUR = Portfolio::firstOrNew(['name' => 'Test portfolio in EUR', 'cash' => 2000]);
        $portfolioUSD = Portfolio::firstOrNew(['name' => 'Test portfolio in EUR', 'cash' => 2000]);

        // assign user and currency
        $portfolioEUR->currency()->associate($ccyEUR);
        $portfolioEUR->user()->associate($user);
        $portfolioEUR->save();

        $portfolioUSD->currency()->associate($ccyUSD);
        $portfolioUSD->user()->associate($user);
        $portfolioUSD->save();

        // put stocks into the portfolios
        $this->assignPosition($portfolioEUR, $stockALV, 10);
        $this->assignPosition($portfolioEUR, $stockBAS, 20);
        $this->assignPosition($portfolioEUR, $stockDAI, 30);

        $this->assignPosition($portfolioUSD, $stockALV, 10);
        $this->assignPosition($portfolioUSD, $stockBAS, 20);
        $this->assignPosition($portfolioUSD, $stockDAI, 30);
    }


    private function assignPosition($portfolio, $instrument, $number)
    {
        $position = new Position(['number' => $number]);

        $position->portfolio()->associate($portfolio);
        $position->positionable()->associate($instrument);

        $position->save();


    }
}
