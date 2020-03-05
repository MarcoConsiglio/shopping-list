<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ShoppingListManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Un utente può vedere un indice delle sue liste della spesa.
     * @test
     */
    public function a_user_can_view_shopping_lists_index()
    {
        // Arrange
        $user = factory(User::class)->create();
        $user->shopping_lists()->save(factory(ShoppingList::class)->make());
        $this->be($user);

        // Act & Assert
        $this->get(route("shopping_list.index"))
             ->assertViewIs("shopping_list.index");
    }
}
