<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Enumerations\ProductType;
use App\Models\Enumerations\ProductMeasure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * It makes App\Models\Product instances.
 */
class ProductFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        switch ($this->productType()) {
            case ProductType::RETAIL:
                return [
                    "name" => $this->getName(),
                    "brand" => $this->getBrand(),
                    "price" => $this->faker->randomFloat(2, 0, 1000),
                    "quantity" => $this->faker->randomDigitNotNull,
                    "cart_quantity" => $this->faker->randomDigitNotNull,
                    "measure" => null,
                    "note" => $this->faker->sentence(5)
                ];
                break;
            case ProductType::WHOLESALE:
                $measure = $this->getMeasure();
                return [
                    "name" => $this->getName(),
                    "brand" => $this->getBrand(),
                    "price" => $this->faker->randomFloat(2, 0, 1000),
                    "quantity" => $this->getQuantityForWholesale($measure),
                    "cart_quantity" => $this->getQuantityForWholesale($measure),
                    "measure" => $measure,
                    "note" => $this->faker->sentence(5)
                ];
        }
    }

    /**
     * Randomly generates the product type (retail or wholesale).
     *
     * @param integer $retail_probability The probability to get a retail Product.
     * @return App\Models\Enumerations\ProductType::RETAIL|App\Models\Enumerations\ProductType::WHOLESALE
     */
    private function productType(int $retail_probability = 75)
    {
        $retail = $this->faker->boolean($retail_probability);
        if ($retail)
            return ProductType::RETAIL;
        else
            return ProductType::WHOLESALE;
    }

    /**
     * Get a random measure for a wholesale Product.
     *
     * @return string A random measure.
     */
    private function getMeasure()
    {
        return $this->faker->randomElement([
            ProductMeasure::MILLILITERS,
            ProductMeasure::LITERS,
            ProductMeasure::GRAMS,
            ProductMeasure::HECTOGRAMS,
            ProductMeasure::KILOS
        ]);
    }

    /**
     * Get a random name for a Product.
     *
     * @return string A random name.
     */
    private function getName()
    {
        do {
            $name = $this->faker->word;
        } while (strlen($name) < 3 || strlen($name) > 50);
        return $name;
    }

    /**
     * Get a random brand for a Product.
     *
     * @return string A random brand.
     */
    private function getBrand()
    {
        do {
            $brand = $this->faker->word;
        } while (strlen($brand) > 50);
        return $brand;
    }

    /**
     * Get a random quantity for a wholesales Product.
     *
     * @param \App\Models\Enumerations\ProductMeasure $measure
     * @return int|float
     */
    private function getQuantityForWholesale(ProductMeasure $measure)
    {
        switch ($measure) {
            case ProductMeasure::MILLILITERS:
                return $this->faker->randomElement([
                    10, 50, 100, 250
                ]);
                break;
            case ProductMeasure::LITERS:
                return $this->faker->randomElement([
                    1, 1.5, 2, 3, 4, 5
                ]);
                break;
            case ProductMeasure::GRAMS:
                return $this->faker->randomElement([
                    10, 20, 50, 100, 250
                ]);
            case ProductMeasure::HECTOGRAMS:
                return $this->faker->randomElement([
                    0.33, 0.5, 0.66, 0.75, 1, 1.5, 2, 3, 4, 5
                ]);
                break;
            case ProductMeasure::KILOS:
                return $this->faker->randomElement([
                    1, 1.5, 2, 2.5, 3, 5
                ]);
                break;
        }
    }

    /**
     * Set the Product is taken.
     *
     * @return void
     */
    public function taken()
    {
        return $this->state(function (array $attributes) {
            return [
                "cart_quantity" => $attributes["quantity"],
                "deleted_at" => Carbon::now()
            ];
        });
    }
}
