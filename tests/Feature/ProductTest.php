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
}
