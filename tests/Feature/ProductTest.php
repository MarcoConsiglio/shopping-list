<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\{User, ShoppingList, Product};

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Un utente può aggiungere un prodotto ad una lista della spesa.
     * @test
     */
    public function a_user_can_add_a_product()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = factory(ShoppingList::class)->make();
        $user->shopping_lists()->save($shopping_list);
        $product = factory(Product::class)->make();
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
        $user = factory(User::class)->create();
        $shopping_list = factory(ShoppingList::class)->make();
        $user->shopping_lists()->save($shopping_list);
        $product = factory(Product::class)->make();
        $shopping_list->refresh();
        $shopping_list->products()->save($product);

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
        $user = factory(User::class)->create();
        $shopping_list = factory(ShoppingList::class)->make();
        $user->shopping_lists()->save($shopping_list);
        $shopping_list->refresh();
        $product = factory(Product::class)->make();
        $shopping_list->products()->save($product);
        $product->refresh();
        $edited_product = factory(Product::class)->make();
        $edited_product->id = $product->id;

        // Act
        $response = $this->actingAs($user)
                         ->put(route("shopping_list.product.update", [$shopping_list, $product]),
                               $edited_product->getAttributes());

        // Assert
        $this->assertdatabaseHas("products", $edited_product->getAttributes());
        $response->assertRedirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Un utente può aggiungere un prodotto al carrello.
     * @test
     */
    public function a_user_can_add_a_product_to_the_cart() {
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = factory(ShoppingList::class)->make();
        $user->shopping_lists()->save($shopping_list);
        $shopping_list->refresh();
        $product = factory(Product::class)->make();
        $shopping_list->products()->save($product);
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
}
