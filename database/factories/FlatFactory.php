<?php

use Faker\Generator as Faker;

$factory->define(App\Flat::class, function (Faker $faker) {
    return [
        'name'		=> $faker->word,
        'tenant_mobile'		=> $faker->phoneNumber,
        'details'	=> $faker->paragraph,
        'tenant_name'		=> $faker->name,
    ];
});
