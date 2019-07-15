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
    return [
        'name' => 'Tom Hanks',
        'email' => 'tom@gmail.com',
        'password' => Hash::make('112358'),
        'image' => 'avatar.jpg',
        'remember_token' => str_random(10),
    ];
});
