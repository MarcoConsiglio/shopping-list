<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, Product, ShoppingList};

class ShoppingListTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var \App\Models\User
         */
        $this->user =
            User::factory()
                ->has(ShoppingList::factory()
                    ->has(Product::factory())
                )->create();
        $this->be($this->user);
        /**
         * @var \App\Models\ShoppingList
         */
        $this->shopping_list = ShoppingList::firstOrFail();

        /**
         * @var \App\Models\ShoppingList
         */
        $this->edited_shopping_list = ShoppingList::factory()->make();

        /**
         * @var \App\Models\Product
         */
        $this->product = Product::find(1);
    }

    /**
     * Un utente può vedere la collezione delle sue liste della spesa.
     * @test
     */
    public function a_user_can_view_shopping_lists_index()
    {
        // $this->withoutExceptionHandling();
        // Arrange in setUp()

        // Act
        $response = $this->get(route("shopping_list.index", $this->shopping_list));

        // Assert
        $response->assertViewIs("shopping_list.index")
                 ->assertSee($this->shopping_list->title);
    }

    /**
     * Un utente può vedere gli elementi di una lista della spesa.
     * Gli elementi inseriti nel carrello si vedono in fondo alla vista.
     * @test
     */
    public function a_user_can_view_shopping_list_items()
    {
        // $this->withoutExceptionHandling();
        // Arrange in setUp()

        // Act
        $response = $this->get(route("shopping_list.show", $this->shopping_list));
        // dd($response->content());

        // Assert
        $response->assertViewIs("shopping_list.show");
        $response->assertSee($this->product->name);
    }


    /**
     * Un utente può modificare una lista della spesa.
     * @test
     */
    public function a_user_can_edit_shopping_list()
    {
        // $this->withoutExceptionHandling();
        // Arrange in setUp()
        $attributes = $this->edited_shopping_list->attributesToArray();
        unset($attributes["created_at"]);
        unset($attributes["updated_at"]);

        // Act
        $response = $this->put(
            route("shopping_list.update", $this->shopping_list),
            $attributes
        );

        // Assert
        $response->assertRedirect(route("shopping_list.index"));
        $this->assertDatabaseHas("shopping_lists", $this->edited_shopping_list->attributesToArray());
    }

    /**
     * Un utente può eliminare una lista della spesa
     * @test
     */
    public function a_user_can_delete_a_shopping_list()
    {
        // Arrange in setUp)=

        // Act
        $response = $this->delete(
            route("shopping_list.destroy", $this->shopping_list)
        );

        // Assert
        $response->assertRedirect(route("shopping_list.index"));
        $this->assertDatabaseMissing("shopping_lists", $this->shopping_list->attributesToArray());
    }

    /**
     * Un utente può creare una lista della spesa.
     * @test
     */
    public function a_user_can_create_a_shopping_list()
    {
        // Arrange

        // Act
        $response = $this->post(
            route("shopping_list.store"),
            $this->edited_shopping_list->attributesToArray()
        );

        // Assert
        $this->assertDatabaseHas("shopping_lists", $this->edited_shopping_list->attributesToArray());
        $response->assertRedirect(route("shopping_list.index"));
    }
}
