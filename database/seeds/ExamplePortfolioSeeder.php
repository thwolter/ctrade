<?php

use Illuminate\Database\Seeder;
use App\Entities\Portfolio;
use App\Entities\Category;
use App\Entities\User;
use App\Entities\Currency;
use App\Entities\PortfolioImage;

class ExamplePortfolioSeeder extends Seeder
{

    protected $exampleResource = 'assets/img/examples/';


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
            'img_url' => 'green-energy.jpg',
            'description' => 'Das Portfolio enthält 10 Werte aus dem Deutschen Aktienindex',
            'category' => 'Dax',
            'currency' => 'EUR'
        ]);

        $this->savePortfolio($user, [
            'name' => 'Andere Werte',
            'cash' => 1000,
            'img_url' => 'car-fuel.jpg',
            'description' => 'Das Portfolio enthält 10 Werte aus dem Deutschen Aktienindex',
            'category' => 'Dax',
            'currency' => 'EUR'
        ]);

        $this->savePortfolio($user, [
            'name' => 'Und noch mehr',
            'cash' => 1000,
            'img_url' => 'laptop.jpg',
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
            'description' => $parm['description']
        ]);

        $category = Category::firstOrCreate(['name' => $parm['category']]);
        $portfolio->category()->associate($category);

        $currency = Currency::firstOrCreate(['code' => $parm['currency']]);
        $portfolio->currency()->associate($currency);

        $user->portfolios()->save($portfolio);

        $this->saveImage($portfolio, $parm['img_url']);
    }



    private function saveImage($portfolio, $url)
    {
        File::copy(resource_path($this->exampleResource . $url),
            storage_path('app/public/images/' . $url));

        $image = new PortfolioImage(['path' => $url]);
        $portfolio->image()->save($image);
    }
}
