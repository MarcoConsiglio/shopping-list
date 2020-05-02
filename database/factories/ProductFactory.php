<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $wholesale = $faker->boolean(30);
    if($wholesale)
    {
        $measure = $faker->randomElement([
            "ml", "l", "g", "hg", "kg"
        ]);
        switch ($measure) {
            case 'ml':
                $quantity = $faker->randomElement([
                    10, 50, 100, 250
                ]);
                $cart_quantity = $faker->randomElement([
                    $quantity, 0
                ]);
                break;

            case 'l':
                $quantity = $faker->randomElement([
                    1, 2, 3, 4, 5
                ]);
                $cart_quantity = $faker->randomElement([
                    $quantity, 0
                ]);
                break;

            case 'g':
                $quantity = $faker->randomElement([
                    10, 20, 50, 100, 250
                ]);
                $cart_quantity = $faker->randomElement([
                    $quantity, 0
                ]);
                break;

            case 'hg':
                $quantity = $faker->randomElement([
                    1, 2, 3, 4, 5
                ]);
                $cart_quantity = $faker->randomElement([
                    $quantity, 0
                ]);
                break;

            case 'kg':
                $quantity = $faker->randomElement([
                    1, 2
                ]);
                $cart_quantity = $faker->randomElement([
                    $quantity, 0
                ]);
                break;

            default:
                $quantity = 1;
                $cart_quantity = 0;
                break;
        }
    }
    else
    {
        $quantity = $faker->randomDigit;
        $cart_quantity = $faker->randomElement([$quantity, 0]);
    }
    return [
        "name" => $faker->word,
        "brand" => $faker->word,
        "price" => $faker->randomFloat(2, 0, 23),
        "quantity" => $quantity,
        "cart_quantity" => $cart_quantity,
        "measure" => $wholesale ? $measure : null,
        "note" => $faker->sentence(5)
    ];
});
