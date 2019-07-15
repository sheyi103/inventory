<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name'		=> $faker->word,
        'vat'		=> $faker->numberBetween(1, 10),
        'details'	=> $faker->paragraph,
        'image'		=> 'default.png',
        'stock'	=> '0',
    ];
});
