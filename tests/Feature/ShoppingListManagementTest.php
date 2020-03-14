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
        $this->withoutExceptionHandling();
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list =
            $user->shopping_lists()
                 ->save(
                     factory(ShoppingList::class)->make()
                 );
        $this->be($user);

        // Act
        $shopping_list->title = $this->faker->sentence(4);
        $response = $this->get(route("shopping_list.update", $shopping_list));

        // Assert
        $response->assertViewIs("shopping_list.index");
        $attributes = $shopping_list->toArray();
        unset($attributes["updated_at"]);
        $this->assertDatabaseHas($shopping_list->table_name, $shopping_list->raw());
    }

}
