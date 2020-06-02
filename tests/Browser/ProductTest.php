<?php

namespace Tests\Browser;

use App\{ShoppingList, User, Product};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Un utente può aggiungere un prodotto ad una lista della spesa.
     * @test
     */
    public function a_user_can_add_a_product()
    {
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = $user->shopping_lists()->save(
            factory(ShoppingList::class)->make()
        );
        $product = factory(Product::class)->make();

        // Act & Assert
        $this->browse(function (Browser $browser) use ($user, $shopping_list, $product){
            $browser->loginAs($user)
                    ->visit(route("shopping_list.show", $shopping_list))
                    ->click("@add_product")
                    ->whenAvailable(".modal",
                        function ($modal) use ($shopping_list, $product) {
                            $modal->type("name", $product->name)
                                  ->type("brand", $product->brand)
                                  ->type("price", $product->price)
                                  ->type("quantity", $product->quantity);
                            if($product->measure)
                                $modal->select("measure", $product->measure);
                            $modal->type("note", $product->note)
                                  ->click("@add_product_modal_button");
                        })
                    ->assertSee($product->name)
                    ->assertSee($product->brand)
                    ->assertSee($product->price)
                    ->assertSee($product->quantity);
            if($product->measure)
                $browser->assertSee($product->measure);
            $browser->assertSee($product->note)
                    ->assertRouteIs("shopping_list.show", compact("shopping_list"));
        });
    }

    /**
     * Un utente può cancellare un prodotto da una lista della spesa.
     * @test
     **/
    public function a_user_can_delete_a_product()
    {
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = $user->shopping_lists()
                              ->save(factory(ShoppingList::class)->make());
        $product = $shopping_list->products()
                                 ->save(factory(Product::class)->make());

        // Act & Assert
        $this->browse(function (Browser $browser) use ($user, $shopping_list, $product) {
            $browser->loginAs($user)
                    ->visit(route("shopping_list.show", $shopping_list))
                    ->click("@delete_product_{$product->id}")
                    ->whenAvailable(".modal#deleteProductModal_{$product->id}",
                        function ($modal) use ($product) {
                            $modal->click("@delete_product_button_modal_{$product->id}");
                        }
                    )
                    ->assertMissing($product->name)
                    ->assertRouteIs("shopping_list.show", $shopping_list);
        });
    }

    /**
     * Un utente può modificare un prodotto di una lista della spesa.
     * @test
     */
    public function a_user_can_update_a_product()
    {
        // Arrange
        $user = factory(User::class)->create();
        $shopping_list = $user->shopping_lists()->save(factory(ShoppingList::class)->make());
        $product = $shopping_list->products()->save(factory(Product::class)->make());
        $edited_product = factory(Product::class)->make();
        $edited_product->id = $product->id;

        // Act & Assert
        $this->browse(function (Browser $browser) use ($user, $shopping_list, $product, $edited_product) {
            $browser->loginAs($user)
                    ->visit(route("shopping_list.show", $shopping_list))
                    ->click("@edit_product_{$product->id}")
                    ->whenAvailable("#editProductModal_{$product->id}",
                        function ($modal) use ($edited_product, $product) {
                            $modal->assertInputValue("name", $product->name)
                                  ->assertInputValue("brand", $product->brand)
                                  ->assertInputValue("price", $product->price)
                                  ->assertInputValue("quantity", $product->quantity);
                            $modal->type("name", $edited_product->name)
                                  ->type("brand", $edited_product->brand)
                                  ->type("price", $edited_product->price)
                                  ->type("quantity", $edited_product->quantity);
                            if($edited_product->measure)
                                $modal->select("measure", $edited_product->measure);
                            $modal->type("note", $edited_product->note)
                                  ->click("@update_product_{$edited_product->id}_modal_button");
                        })
                    ->assertSee($edited_product->name)
                    ->assertSee($edited_product->brand)
                    ->assertSee($edited_product->price)
                    ->assertSee($edited_product->quantity);
            if($edited_product->measure)
                $browser->assertSee($edited_product->measure);
            $browser->assertSee($edited_product->note)
                    ->assertRouteIs("shopping_list.show", compact("shopping_list"));
        });
    }

}
