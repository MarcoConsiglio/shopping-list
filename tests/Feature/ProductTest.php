<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, ShoppingList, Product};

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Un utente può aggiungere un prodotto ad una lista della spesa.
     * @test
     */
    public function a_user_can_add_a_product()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory())
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::factory()->make();
        $attributes = $product->getAttributes();

        // Act
        $response = $this->actingAs($user)
                         ->post(route("shopping_list.product.store", $shopping_list), $attributes);

        // Re-arrenge
        $attributes = $product->refresh()->getAttributes();

        // Assert
        $this->assertDatabaseHas("products", $attributes);
        $response->assertRedirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Un utente può eliminare un prodotto da una lista della spesa
     * @test
     */
    public function a_user_can_delete_a_product()
    {
        // Arrange
        $user = User::factory()
        ->has(ShoppingList::factory()
            ->has(Product::factory()))
        ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::firstOrFail();

        // Act
        $response = $this->actingAs($user)
                         ->delete(route("shopping_list.product.destroy", [$shopping_list, $product]));

        // Assert
        $this->assertDatabaseMissing("products", $product->getAttributes());
        $response->assertRedirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Un utente può modificare un prodotto di una lista della spesa.
     * @test
     */
    public function a_user_can_edit_a_product()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory()
                        ->has(Product::factory()))
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::firstOrFail();
        $edited_product = Product::factory()->make();

        // Act
        $response = $this->actingAs($user)
                         ->put(route("shopping_list.product.update", [$shopping_list, $product]),
                                     $edited_product->getAttributes());

        // Assert
        $edited_product->id = $product->id;
        $this->assertdatabaseHas("products", $edited_product->getAttributes());
        $response->assertRedirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Un utente può aggiungere un prodotto al carrello.
     * @test
     */
    public function a_user_can_add_a_product_to_the_cart() {
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory()
                        ->has(Product::factory()))
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::firstOrFail();
        $attributes = $product->getAttributes();
        $added_quantity = $product->quantity;

        // Act
        $response = $this->actingAs($user)
                         ->post(route("shopping_list.product.add_to_cart",
                                      compact(["product", "shopping_list"])),
                         ["cart_quantity" => $added_quantity]);
        $product->refresh();

        // Assert
        $attributes = $product->attributesToArray();
        $attributes["cart_quantity"] = (float)$added_quantity;
        unset(
            $attributes["created_at"],
            $attributes["updated_at"]
        );
        $this->assertDatabaseHas("products", $attributes);
        $response->assertRedirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Un utente non può aggiungere una quantità negativa al carrello.
     * @test
     */
    public function a_user_cant_add_negative_quantity_to_the_cart() {
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory()
                        ->has(Product::factory()))
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::firstOrFail();

        // Act
        $response = $this->actingAs($user)
                         ->post(route("shopping_list.product.add_to_cart",
                                compact(["product", "shopping_list"])),
                    ["cart_quantity" => 0 - $this->faker->randomDigitNotNull()]);
        $product->refresh();

        // Assert
        $response->assertSessionHasErrors(["cart_quantity"]);
    }
}
