<?php

use Faker\Generator as Faker;

$factory->define(LaravelVueJs\Models\MenuItem::class, function (Faker $faker) {
    return [
        'label' => $faker->text(6),
        'order' => $faker->numberBetween(0, 10),
        'url'   => '/' . $faker->text(10),
    ];
});
