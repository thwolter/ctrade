<?php


use App\Entities\Portfolio;
use App\Entities\User;
use App\Entities\Currency;

$factory->define(Portfolio::class, function(Faker\Generator $faker) {

    $currency = Currency::firstOrCreate(['code' => factory(Currency::class)->make()->code]);

    return  [
        'user_id' => factory(User::class)->create()->id,
        'name' => $faker->streetName,
        'currency_id' => $currency->id,
        'opened_at' => $faker->dateTimeBetween('-2 month')
    ];
});

$factory->state(Portfolio::class, 'USD', function() {

    return [
        'currency_id' => Currency::firstOrCreate(['code' => 'USD'])->id
    ];
});
