<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ShoppingList;
use Faker\Generator as Faker;

$factory->define(ShoppingList::class, function (Faker $faker) {
    return [
        "title" => $faker->sentence(5)
    ];
});
