<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/






$factory->define(App\Entities\Sector::class, function(Faker\Generator $faker) {

    return [
        'name' => $faker->word
    ];
});



$factory->define(\App\Entities\Dataset::class, function(Faker\Generator $faker) {

    return [
        'code' => $faker->word
    ];
});


$factory->define(\App\Entities\Database::class, function(Faker\Generator $faker) {

    return [
        'code' => $faker->word,
    ];
});


$factory->define(\App\Entities\Provider::class, function(Faker\Generator $faker) {

    return [
        'code' => $faker->word,
    ];
});
