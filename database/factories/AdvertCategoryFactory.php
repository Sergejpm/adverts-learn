<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Entity\Adverts\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'parent_id' => null,
    ];
});