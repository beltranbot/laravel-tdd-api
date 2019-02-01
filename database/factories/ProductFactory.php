<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    $name = $faker->company;
    $price = random_int(10, 100);

    return [
        'name' => $faker->name,
        'slug' => str_slug($name),
        'price' => $price,
    ];
});
