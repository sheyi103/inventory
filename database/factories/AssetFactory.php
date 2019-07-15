<?php

use Faker\Generator as Faker;

$factory->define(App\Asset::class, function (Faker $faker) {
    return [
        'name'		=> $faker->word,
        'date'	    => $faker->date('Y-m-d'),
        'amount'	=> 100000,
        'details'	=> $faker->paragraph,
    ];
});
