<?php

use App\Entities\Dataset;
use Faker\Generator as Faker;

$factory->define(Dataset::class, function (Faker $faker) {
    return [
        'code' => $faker->word
    ];
});


$factory->state(Dataset::class, 'currency', function (Faker $faker) {

    return [
        'code' => 'EUR' . $faker->randomElement(['USD', 'CZK', 'CHF'])
    ];
});


$factory->state(Dataset::class, 'stock', function (Faker $faker) {

    return [
        'code' => $faker->randomElement(['SVHG', 'NA8P', 'XTL1', 'N2X1', 'CEC1', 'CCP'])
    ];
});
