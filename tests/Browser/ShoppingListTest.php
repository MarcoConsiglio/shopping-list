<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\{User, ShoppingList};

class ShoppingListTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * Un utente può vedere una collezione liste della spesa.
     * @test
     */
    public function a_user_can_view_shopping_lists_collection()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = factory(ShoppingList::class)->make();
        $user->shopping_lists()->save($shopping_list);

        // Act & Assert
        $this->browse(
            function (Browser $browser) use ($user, $shopping_list)
            {
                $browser->loginAs($user)
                        ->visit(route("shopping_list.index"))
                        ->assertSee($shopping_list->title);
            }
        );
    }

    /**
     * Un utente può modificare la sua lista della spesa.
     * @test
     */
    public function a_user_can_edit_a_shopping_list()
    {
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = factory(ShoppingList::class)->make();
        $user->shopping_lists()->save($shopping_list);
        $new_title = $this->faker->sentence(3);

        // Act & Assert
        $this->browse(
            function (Browser $browser) use ($user, $shopping_list, $new_title) {
                $browser->loginAs($user)
                        ->visit(route("shopping_list.index"))
                        ->click("@edit_button_{$shopping_list->id}");
                $browser->whenAvailable('.modal', function ($modal) use ($shopping_list, $new_title){
                    $modal->assertSee($shopping_list->title)
                          ->assertInputValue('title', $shopping_list->title)
                          ->type('title', $new_title)
                          ->click("@edit_modal_button_{$shopping_list->id}")
                          ->assertRouteIs("shopping_list.index");
                });
                $browser->assertSee($new_title);
            }
        );
    }
}
