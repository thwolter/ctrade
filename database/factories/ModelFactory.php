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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Entities\Portfolio::class, function(Faker\Generator $faker) {
    return  [
        'user_id' => function() {
            return factory('App\Entities\User')->create()->id;
        },
        'name' => $faker->sentence,
        'currency' => $faker->currencyCode,
        'cash' => 100 * $faker->randomDigitNotNull
    ];
});



$factory->define(App\Entities\Stock::class, function() {
    return [
        'symbol' => 'ALV.DE'
    ];
});


$factory->define(App\Entities\Position::class, function(Faker\Generator $faker) {

    $stock = factory('App\Entities\Stock')->create();
    $portfolio = factory('App\Entities\Portfolio')->create();

    return [
        'portfolio_id' => $portfolio->id,
        'positionable_id' => $stock->id,
        'positionable_type' => get_class($stock),
        'amount' => $faker->randomDigitNotNull
    ];
});