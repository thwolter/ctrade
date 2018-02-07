<?php

use App\Entities\Currency;
use Faker\Generator as Faker;


$factory->define(Currency::class, function (Faker $faker) {
    return [
        'code' => $faker->randomElement(['EUR', 'USD', 'CZK']),
        'eligible' => $faker->randomElement([0, 1])
    ];
});


$factory->state(Currency::class, 'USD', [
    'code' => 'USD'
]);


$factory->state(Currency::class, 'EUR', [
    'code' => 'EUR'
]);


$factory->state(Currency::class, 'CZK', [
    'code' => 'CZK'
]);


$factory->state(Currency::class, 'eligible', [
    'eligible' => 1
]);