<?php

use Faker\Generator as Faker;

$factory->define(App\RawMaterial::class, function (Faker $faker) {
    return [
        'name'		=> $faker->word,
        'details'	=> $faker->paragraph,
        'stock'	=> '0',
    ];
});
