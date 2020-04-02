<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\ShoppingList;

class ShoppingListManagementTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A User can view ShoppingLists.
     * @test
     */
    public function a_user_can_view_shopping_lists_index()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = $user->shopping_lists()->save(factory(ShoppingList::class)->make());
        $this->be($user);

        // Act
        $response = $this->get(route("shopping_list.index", $shopping_list));

        // Assert
        $response->assertViewIs("shopping_list.index")
                 ->assertSee($shopping_list->title);
    }

    /**
     * A User can view ShoppingList items.
     * @test
     */
    public function a_user_can_view_shopping_list_items()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = $user->shopping_lists()->save(factory(ShoppingList::class)->make());
        $this->be($user);

        // Act
        $response = $this->get(route("shopping_list.show", $shopping_list));

        // Assert
        $response->assertViewIs("shopping_list.show");
    }


    /**
     * A User can edit ShoppingList.
     * @test
     */
    public function a_user_can_edit_shopping_list()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list =
            $user->shopping_lists()
                 ->save(factory(ShoppingList::class)->make());
        $this->be($user);
        $edited_shopping_list = $shopping_list;
        $edited_shopping_list->title = $this->faker->sentence(4);
        $attributes = $edited_shopping_list->getAttributes();
        unset($attributes["updated_at"]);

        // Act
        $response = $this->put(
            route("shopping_list.update", $edited_shopping_list),
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
        $user = factory(User::class)->create();
        $shopping_list =
            $user->shopping_lists()
                 ->save(factory(ShoppingList::class)->make());
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
        $user = factory(User::class)->create();
        $shopping_list =
            $user->shopping_lists()
                 ->save(factory(ShoppingList::class)->make());
        $attributes = $shopping_list->getAttributes();
        $this->be($user);

        // Act
        $response = $this->post(
            route("shopping_list.store", $shopping_list)
        );

        // Assert
        $response->assertRedirect(route("shopping_list.index"));
        $this->assertDatabaseHas("shopping_lists", $attributes);
    }
}
