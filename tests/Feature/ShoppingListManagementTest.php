<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\ShoppingList;

class ShoppingListManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A User can view ShoppingLists.
     * @test
     */
    public function a_user_can_view_shopping_lists_index()
    {
        $this->withoutExceptionHandling();
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
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = $user->shopping_lists()->save(factory(ShoppingList::class)->make());

        // Act
        $response = $this->get(route("shopping_list.show", $shopping_list));

        // Assert
        $response->assertViewIs("shopping_list.show")
                 ->assertSee($shopping_list->title);
    }

}
