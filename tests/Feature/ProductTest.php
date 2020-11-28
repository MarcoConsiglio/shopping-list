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
     * A User of this app.
     *
     * @var \App\User
     */
    private $user;

    /**
     * A ShoppingList.
     *
     * @var \App\ShoppingList
     */
    private $shopping_list;

    /**
     * A Product.
     *
     * @var \App\Product
     */
    private $product;

    /**
     * Set up.
     *
     * @param boolean $make_user            Weather to make a User instead of persist it.
     * @param boolean $make_shopping_list   Weather to make a ShoppingList instead of persist it.
     * @param boolean $make_product         Weather to make a Product instead of persist it.
     * @return void
     */
    protected function setUp(
        bool $make_user = false,
        bool $make_shopping_list = false,
        bool $make_product = false): void
    {
        parent::setUp();

        // Set models.
        $make_user ?
            $this->user = factory(User::class)->make() :
            $this->user = factory(User::class)->create();

        $make_shopping_list ?
            $this->shopping_list = factory(ShoppingList::class)->make() :
            $this->shopping_list = factory(ShoppingList::class)->create([
                "user_id" => $this->user->id
            ]);

        $make_product ?
            $this->product = factory(Product::class)->make() :
            $this->product = factory(Product::class)->create([
                "shopping_list_id" => $this->shopping_list->id
            ]);
    }

    /**
     * Un utente può aggiungere un prodotto ad una lista della spesa.
     * @test
     */
    public function a_user_can_add_a_product()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $this->setUp(false, false, true);

        // Act
        $response = $this->actingAs($this->user)
                         ->post(
                             route(
                                 "shopping_list.product.store",
                                 $this->shopping_list
                             ),
                             $this->product->attributesToArray()
                         );

        // Re-arrenge
        $attributes = $this->product->refresh()->getAttributes();

        // Assert
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
        $edited_product = factory(Product::class)->make();

        // Act
        $response = $this->actingAs($this->user)
                         ->put(
                             route(
                                 "shopping_list.product.update",
                                 [$this->shopping_list, $this->product]
                             ),
                             $edited_product->getAttributes()
                         );

        // Assert
        $this->assertdatabaseHas("products", $edited_product->getAttributes());
        $response->assertRedirect(route("shopping_list.show", $this->shopping_list));
    }

    /**
     * Un utente può aggiungere un prodotto al carrello.
     * @test
     */
    public function a_user_can_add_a_product_to_the_cart() {
        // Arrange in setUp()
        $added_quantity = $this->product->quantity;

        // Act
        $response = $this->actingAs($this->user)
                         ->post(
                             route(
                                 "shopping_list.product.add_to_cart",
                                 [$this->shopping_list, $this->product]
                             ),
                             ["cart_quantity" => $added_quantity]
                         );
        $this->product->refresh();

        // Assert
        $attributes = $this->product->attributesToArray();
        $attributes["cart_quantity"] = (float)$added_quantity;
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
        ->post(
            route(
                "shopping_list.product.add_to_cart",
                [$this->shopping_list, $this->product]
            ),
            ["cart_quantity" => -5]
        );
        $this->product->refresh();

        // Assert
        $response->assertSessionHasErrors(["cart_quantity"]);
    }
}
