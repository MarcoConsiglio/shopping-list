<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\{User, ShoppingList, Product};

class ShoppingListTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Models\User
     */
    private $user;

    /**
     * @var \App\Models\ShoppingList
     */
    private $shopping_list;

    /**
     * @var \App\Models\ShoppingList
     */
    private $made_shopping_list;

    /**
     * @var \App\Models\Product
     */
    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user =
            User::factory()
                ->has(ShoppingList::factory()
                    ->has(Product::factory()))
                ->create();

        $this->shopping_list = ShoppingList::firstOrFail();

        $this->made_shopping_list = ShoppingList::factory()->make();

        $this->product = Product::firstOrFail();
    }

    /**
     * Un utente può vedere una collezione liste della spesa.
     * @test
     */
    public function a_user_can_view_shopping_lists_collection()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $user = $this->user;
        $shopping_list = $this->shopping_list;

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
     * Un utente può modificare una lista della spesa.
     * @test
     */
    public function a_user_can_edit_a_shopping_list()
    {
        // Arrange
        $user = $this->user;
        $shopping_list = $this->shopping_list;
        $new_title = $this->made_shopping_list->title;

        // Act & Assert
        $this->browse(
            function (Browser $browser) use ($user, $shopping_list, $new_title) {
                $browser->loginAs($user)
                        ->visit(route("shopping_list.index"))
                        ->click("@edit_button_{$shopping_list->id}")
                        ->whenAvailable("#edit_modal_{$shopping_list->id}",
                        function ($modal) use ($shopping_list, $new_title){
                            $modal->assertSee($shopping_list->title)
                                ->assertInputValue('title', $shopping_list->title)
                                ->type('title', $new_title)
                                ->click("@edit_modal_button_{$shopping_list->id}")
                                ->assertRouteIs("shopping_list.index");
                        });
                $browser->assertSee($new_title);
            });
    }

    /**
     * Un utente può cancellare una lista della spesa.
     * @test
     */
    public function a_user_can_delete_a_shopping_list()
    {
        // Arrange
        $user = $this->user;
        $shopping_list = $this->shopping_list;

        // Act & Assert
        $this->browse(
            function (Browser $browser) use ($user, $shopping_list){
                $browser->loginAs($user)
                        ->visit(route("shopping_list.index"))
                        ->click("@delete_button_{$shopping_list->id}")
                        ->whenAvailable("#delete_modal_{$shopping_list->id}",
                            function ($modal) use ($shopping_list){
                                $modal->assertSee($shopping_list->title)
                                    ->click("@delete_modal_button_{$shopping_list->id}")
                                    ->assertRouteIs("shopping_list.index");
                            });
            });
    }

    /**
     * Un utente può creare una lista della spesa.
     * @test
     */
    public function a_user_can_create_a_shopping_list()
    {
        // Arrange
        $user = $this->user;
        $shopping_list = $this->shopping_list;

        // Act & Assert
        $this->browse(
            function (Browser $browser) use ($user, $shopping_list) {
                $browser->loginAs($user)
                        ->visit(route("shopping_list.index"))
                        ->click("@create_button")
                        ->whenAvailable("#createModal",
                        function ($modal) use ($shopping_list){
                            $modal->type('title', $shopping_list->title)
                                ->click("@create_modal_button")
                                ->assertRouteIs("shopping_list.index");
                        });
                $browser->assertSee($shopping_list->title);
            });
    }

    /**
     *  Un utente può vedere una lista della spesa.
     *  @test
     */
    public function a_user_can_view_a_shopping_list()
    {
        // Arrange
        $user = $this->user;
        $shopping_list = $this->shopping_list;
        $product = $this->product;

        // Act & Assert
        $this->browse(
            function (Browser $browser) use ($user, $shopping_list, $product) {
                $browser->loginAs($user)
                        ->visit(route("shopping_list.index"))
                        ->click("@shopping_list_{$shopping_list->id}")
                        ->assertSee("{$product->name}");
            }
        );
    }
}
