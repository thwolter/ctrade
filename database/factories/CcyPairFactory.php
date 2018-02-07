<?php

use App\Entities\CcyPair;
use Faker\Generator as Faker;


$factory->define(CcyPair::class, function (Faker $faker) {
    return [
        'origin' => 'EUR',
        'target' => $faker->randomElement(['USD', 'CZK'])
    ];
});
