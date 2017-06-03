<?php

use Illuminate\Database\Seeder;
use App\Entities\Stock;
use App\Entities\Currency;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ExamplePortfolioSeeder::class);
    }
}
