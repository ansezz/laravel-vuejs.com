<?php

use Faker\Generator as Faker;

$factory->define(\LaravelVueJs\Models\Post::class, function (Faker $faker) {
    return [
        'title'          => $faker->text(200),
        'excerpt'        => $faker->text(100),
        'content'        => $faker->text(2000),
        'type'           => 1,
        'status'         => $faker->numberBetween(0, 3),
        'comment_status' => $faker->numberBetween(0, 1),
        'featured'       => $faker->boolean,
        'views'          => $faker->numberBetween(1, 900000),
    ];
});
