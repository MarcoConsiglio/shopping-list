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
                         ->post(route("product.store", compact("shopping_list")), $attributes);

        // Re-arrenge
        $attributes = $product->refresh()->getAttributes();

        // Assert
        $this->assertDatabaseHas("products", $attributes);
    }

}
