<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\ShoppingList;

class ShoppingListTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Un utente può vedere la collezione delle sue liste della spesa.
     * @test
     */
    public function a_user_can_view_shopping_lists_index()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory())
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $this->be($user);

        // Act
        $response = $this->get(route("shopping_list.index", $shopping_list));

        // Assert
        $response->assertViewIs("shopping_list.index")
                 ->assertSee($shopping_list->title);
    }

    /**
     * Un utente può vedere gli elementi di una lista della spesa.
     * @test
     */
    public function a_user_can_view_shopping_list_items()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory())
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $this->be($user);

        // Act
        $response = $this->get(route("shopping_list.show", $shopping_list));
        // dd($response->content());

        // Assert
        $response->assertViewIs("shopping_list.show");
    }


    /**
     * Un utente può modificare una lista della spesa.
     * @test
     */
    public function a_user_can_edit_shopping_list()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory())
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $this->be($user);
        $edited_shopping_list = ShoppingList::factory()->make();
        $attributes = $edited_shopping_list->getAttributes();
        unset($attributes["updated_at"]);

        // Act
        $response = $this->put(
            route("shopping_list.update", $shopping_list),
            $attributes
        );

        // Assert
        $response->assertRedirect(route("shopping_list.index"));
        $this->assertDatabaseHas("shopping_lists", $attributes);
    }

    /**
     * Un utente può eliminare una lista della spesa
     * @test
     */
    public function a_user_can_delete_a_shopping_list()
    {
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory())
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $attributes = $shopping_list->getAttributes();
        $this->be($user);

        // Act
        $response = $this->delete(
            route("shopping_list.destroy", $shopping_list)
        );

        // Assert
        $response->assertRedirect(route("shopping_list.index"));
        $this->assertDatabaseMissing("shopping_lists", $attributes);
    }

    /**
     * Un utente può creare una lista della spesa.
     * @test
     */
    public function a_user_can_create_a_shopping_list()
    {
        // Arrange
        $user = User::factory()->create();
        $shopping_list = ShoppingList::factory()->make();
        $attributes = $shopping_list->getAttributes();
        $this->be($user);

        // Act
        $response = $this->post(
            route("shopping_list.store"),
            $attributes
        );

        // Assert
        $this->assertDatabaseHas("shopping_lists", $attributes);
        $response->assertRedirect(route("shopping_list.index"));
    }
}
