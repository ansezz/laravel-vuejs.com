<?php

use Faker\Generator as Faker;

$factory->define(LaravelVueJs\Models\Menu::class, function (Faker $faker) {
    return [
        'name'        => $faker->text(10),
        'description' => $faker->text(100),
    ];
});
