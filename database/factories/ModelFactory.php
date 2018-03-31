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

$factory->define(App\User::class, function ($faker) {
    return [
        'username' => $faker->username,
        'email' => $faker->email,
        'phone' => str_random(11),
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\Test::class, function ($faker) {
    return [
        'name' => $faker->username,
        'tag'  =>rand(0,1),
        'price' => rand(3,10),
    ];
});
