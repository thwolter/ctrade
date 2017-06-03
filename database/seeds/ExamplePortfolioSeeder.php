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

        $this->savePortfolio($user, [
            'name' => 'Dax Werte',
            'cash' => 1000,
            'img_url' => asset('img/portfolios/bg-1.jpg'),
            'description' => 'Das Portfolio enthält 10 Werte aus dem Deutschen Aktienindex',
            'category' => 'Dax',
            'currency' => 'EUR'
        ]);

        $this->savePortfolio($user, [
            'name' => 'Andere Werte',
            'cash' => 1000,
            'img_url' => asset('img/portfolios/bg-1.jpg'),
            'description' => 'Das Portfolio enthält 10 Werte aus dem Deutschen Aktienindex',
            'category' => 'Dax',
            'currency' => 'EUR'
        ]);

        $this->savePortfolio($user, [
            'name' => 'Und noch mehr',
            'cash' => 1000,
            'img_url' => asset('img/portfolios/bg-1.jpg'),
            'description' => 'Das Portfolio enthält 10 Werte aus dem Deutschen Aktienindex',
            'category' => 'Dax',
            'currency' => 'EUR'
        ]);
    }

    public function savePortfolio($user, $parm)
    {
        $portfolio = new Portfolio([
            'name' => $parm['name'],
            'cash' => $parm['cash'],
            'img_url' => $parm['img_url'],
            'description' => $parm['description']
        ]);

        $category = Category::firstOrCreate(['name' => $parm['category']]);
        $portfolio->category()->associate($category);

        $currency = Currency::firstOrCreate(['code' => $parm['currency']]);
        $portfolio->currency()->associate($currency);

        $user->portfolios()->save($portfolio);
    }
}
