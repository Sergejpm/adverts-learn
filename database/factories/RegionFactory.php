<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Entity\Region::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->city,
        'parent_id' => null,
    ];
});