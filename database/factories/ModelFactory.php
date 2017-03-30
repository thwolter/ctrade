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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Portfolio::class, function(Faker\Generator $faker) {
    return  [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'name' => $faker->sentence,
        'currency' => $faker->currencyCode,
    ];
});



$factory->define(App\Stock::class, function() {
    return [
        'symbol' => 'ALV.DE',
        'currency' => 'EUR'
    ];
});


$factory->define(App\Position::class, function() {

    $stock = factory('App\Stock')->create();
    $portfolio = factory('App\Portfolio')->create();

    return [
        'portfolio_id' => $portfolio->id,
        'positionable_id' => $stock->id,
        'positionable_type' => get_class($stock)
    ];
});