<?php

use App\Entities\Currency;
use App\Entities\Exchange;
use App\Entities\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {

    $currency = Currency::firstOrCreate(['code' => factory(Currency::class)->make()->code]);

    return [
        'name' => $faker->company,
        'isin' => $faker->numerify('########'),
        'currency_id' => $currency->id
    ];
});

$factory->state(Stock::class, 'USD', function (Faker $faker) {

    return [
        'currency_id' => Currency::firstOrCreate(['code' => 'USD'])->id
    ];
});
