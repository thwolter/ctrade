<?php

use Illuminate\Database\Seeder;
use App\Entities\Portfolio;
use App\Entities\Category;
use App\Entities\User;
use App\Entities\Currency;

class ExamplePortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereName('examples')->first();

        $portfolio = new Portfolio([
            'name' => 'Dax Werte',
            'cash' => 1000,
            'description' => 'Das Portfolio enthält 10 Werte aus dem Deutschen Aktienindex'
        ]);

        $category = Category::firstOrCreate(['name' => 'Dax']);
        $portfolio->category()->associate($category);

        $currency = Currency::firstOrCreate(['code' => 'EUR']);
        $portfolio->currency()->associate($currency);

        $user->portfolios()->save($portfolio);
    }
}
