<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\{User, ShoppingList};

class ShoppingListTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Un utente può vedere una collezione delle sue liste della spesa.
     * @test
     */
    public function a_user_can_view_shopping_lists_collection()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = $user->shopping_lists()->save(
            factory(ShoppingList::class)->make()
        );

        // Act
        $this->browse(function (Browser $browser) use($user, $shopping_list) {
            $browser->loginAs($user)
                    ->visit(route("shopping_list.index"))
                    ->assertSee($shopping_list->title);
        });
    }
}
