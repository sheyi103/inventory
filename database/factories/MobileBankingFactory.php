<?php

use Faker\Generator as Faker;

$factory->define(App\MobileBanking::class, function (Faker $faker) {
    return [
        'name'		=> $faker->company,
    ];
});
