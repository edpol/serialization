<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $fake_email = $faker->unique()->safeEmail;
    return [
        'name'      => $faker->name,
        'email'     => $fake_email,
        'username'  => $fake_email,
        'customer_id' => rand(1,10),
        'password'    => bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});



