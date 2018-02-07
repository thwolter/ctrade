<?php

use App\Entities\Exchange;
use Faker\Generator as Faker;

$factory->define(Exchange::class, function (Faker $faker) {

    return [
        'code' => $faker->company
    ];
});
