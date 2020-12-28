<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, ShoppingList, Product};

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var \App\Models\User
         */
        $this->user =
            User::factory()
                ->has(ShoppingList::factory()
                    ->has(Product::factory()))
                ->create();

        /**
         * @var \App\Models\ShoppingList
         */
        $this->shopping_list = ShoppingList::firstOrFail();

        /**
         * @var \App\Models\Product
         */
        $this->product = Product::firstOrFail();

        /**
         * @var \App\Models\Product
         */
        $this->made_product = Product::firstOrFail();

    }

    /**
     * Un utente può aggiungere un prodotto ad una lista della spesa.
     * @test
     */
    public function a_user_can_add_a_product()
    {
        // $this->withoutExceptionHandling();
        // Arrange in setUp()

        // Act
        $response = $this->actingAs($this->user)
                         ->post(
                             route(
                                 "shopping_list.product.store",
                                 $this->shopping_list
                             ),
                             $this->made_product->attributesToArray()
                         );

        // Assert
        $attributes = $this->made_product->refresh()->getAttributes();
        $this->assertDatabaseHas("products", $attributes);
        $response->assertRedirect(route("shopping_list.show", $this->shopping_list));
    }

    /**
     * Un utente può eliminare un prodotto da una lista della spesa
     * @test
     */
    public function a_user_can_delete_a_product()
    {
        // Arrange in setUp()
        // Act
        $response = $this->actingAs($this->user)
                         ->delete(
                             route("shopping_list.product.destroy",
                             [$this->shopping_list, $this->product])
                         );

        // Assert
        $this->assertDatabaseMissing("products", $this->product->getAttributes());
        $response->assertRedirect(route("shopping_list.show", $this->shopping_list));
    }

    /**
     * Un utente può modificare un prodotto di una lista della spesa.
     * @test
     */
    public function a_user_can_edit_a_product()
    {
        // $this->withoutExceptionHandling();
        // Arrange in setUp()

        // Act
        $response = $this->actingAs($this->user)
                         ->put(route("shopping_list.product.update", [$this->shopping_list, $this->product]),
                                     $this->made_product->getAttributes());

        // Assert
        $this->made_product->refresh();
        $this->assertdatabaseHas("products", $this->made_product->getAttributes());
        $response->assertRedirect(route("shopping_list.show", $this->shopping_list));
    }

    /**
     * Un utente può aggiungere un prodotto al carrello.
     * @test
     */
    public function a_user_can_add_a_product_to_the_cart() {
        // Arrange in setUp()

        // Act
        $response = $this->actingAs($this->user)
                         ->post(
                             route(
                                 "shopping_list.product.add_to_cart",
                                 [$this->shopping_list, $this->product]
                             ),
                             ["cart_quantity" => $this->product->quantity]
                         );
        $this->product->refresh();

        // Assert
        $attributes = $this->product->attributesToArray();
        unset(
            $attributes["created_at"],
            $attributes["updated_at"]
        );
        $this->assertDatabaseHas("products", $attributes);
        $response->assertRedirect(route("shopping_list.show", $this->shopping_list));
    }

    /**
     * Un utente non può aggiungere una quantità negativa al carrello.
     * @test
     */
    public function a_user_cant_add_negative_quantity_to_the_cart() {
        // Arrange in setUp()

        // Act
        $response = $this->actingAs($this->user)
                         ->post(route("shopping_list.product.add_to_cart", [
                                    $this->shopping_list,
                                    $this->product
                                ]),
                    ["cart_quantity" => 0 - $this->faker->randomDigitNotNull()]);
        $this->product->refresh();

        // Assert
        $response->assertSessionHasErrors(["cart_quantity"]);
    }
}
