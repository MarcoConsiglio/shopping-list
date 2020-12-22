<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Enumeration constant for referring to retail product.
     * @var string
     */
    private const RETAIL = 0;

    /**
     * Enumeration constant for referring to wholesale product.
     * @var string
     */
    private const WHOLESALE = 1;

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
        switch($this->productType()) {
            case ProductFactory::RETAIL:
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
            case ProductFactory::WHOLESALE:
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
     * Randomly gets the product type (retail or wholesale).
     *
     * @param integer $retail_probability The probability to get a retail Product.
     * @return boolean true if retail, false if wholesale.
     */
    private function productType(int $retail_probability = 75) {
        $retail = $this->faker->boolean($retail_probability);
        if($retail)
            return ProductFactory::RETAIL;
        else
            return ProductFactory::WHOLESALE;
    }

    /**
     * Get a random measure for a wholesale Product.
     *
     * @return string A random measure.
     */
    private function getMeasure() {
        return $this->faker->randomElement([
            "ml", "l", "g", "hg", "kg"
        ]);
    }

    /**
     * Get a random name for this Product.
     *
     * @return string A random name.
     */
    private function getName() {
        do{
            $name = $this->faker->word;
        } while (strlen($name) < 3 || strlen($name) > 50);
        return $name;
    }

    /**
     * Get a random brand for this Product.
     *
     * @return string A random brand.
     */
    private function getBrand() {
        do {
            $brand = $this->faker->word;
        } while (strlen($brand) > 50);
        return $brand;
    }

    private function getQuantityForWholesale(string $measure) {
        switch($measure) {
            case "ml":
                return $this->faker->randomElement([
                    10, 50, 100, 250
                ]);
                break;
            case "l":
                return $this->faker->randomElement([
                    1, 2, 3, 4, 5
                ]);
                break;
            case "g":
                return $this->faker->randomElement([
                    10, 20, 50, 100, 250
                ]);
            case "hg":
                return $this->faker->randomElement([
                    1, 2, 3, 4, 5
                ]);
                break;
            case "kg":
                return $this->faker->randomElement([
                    1, 2, 3, 5
                ]);
                break;
        }
    }
}
