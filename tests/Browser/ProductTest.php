<?php

namespace Tests\Browser;

use App\Models\{ShoppingList, User, Product};
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
        $user = User::factory()
                    ->has(ShoppingList::factory())
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::factory()->make();

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
                    ->assertSee(number_format($product->price, 2, ",", "."))
                    ->assertSee($product->quantity);
            if($product->measure)
                $browser->assertSee($product->measure);
            $browser->assertSee($product->note)
                    ->assertRouteIs("shopping_list.show", compact("shopping_list"));
        });
    }

    /**
     * Un utente può aggiungere un prodotto al carrello.
     * @test
     */
    public function a_user_can_add_a_product_to_the_cart() {
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory()
                        ->has(Product::factory()))
                    ->create();
            $shopping_list = ShoppingList::firstOrFail();
            $product = Product::firstOrFail();

        // Act & Assert
        $this->browse(function (Browser $browser) use ($user, $shopping_list, $product) {
            $browser->loginAs($user)
                    ->visit(route("shopping_list.show", $shopping_list))
                    ->click("@add_to_cart_{$product->id}")
                    ->whenAvailable(".modal#addToCart_{$product->id}",
                        function ($modal) use ($product) {
                            $modal->assertSee("Quanti ne vuoi mettere nel carrello?")
                                  ->click("@confirm_add_to_cart_{$product->id}");
                        }
                    )
                    ->assertRouteIs("shopping_list.show", ["shopping_list" => $shopping_list->id]);
            if(!$product->measure)
                $browser->assertSeeIn("@cartQuantity_{$product->id}", "x".number_format($product->quantity, 0, ",", "."));
            else
                $browser->assertSeeIn(
                    "@cartQuantity_{$product->id}",
                    number_format($product->quantity, 0, ",", ".")
                    ." ".
                    $product->measure == "hg" ? "etti" : $product->measure);
        });
    }

    /**
     * Un utente può cancellare un prodotto da una lista della spesa.
     * @test
     **/
    public function a_user_can_delete_a_product()
    {
        // Arrange
        $user = User::factory()
                    ->has(ShoppingList::factory()
                        ->has(Product::factory()))
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::firstOrFail();

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
        $user = User::factory()
                    ->has(ShoppingList::factory()
                        ->has(Product::factory()))
                    ->create();
        $shopping_list = ShoppingList::firstOrFail();
        $product = Product::firstOrFail();
        $edited_product = Product::factory()->make();
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
                    ->assertSee(number_format($edited_product->price, 2, ",", ".")  )
                    ->assertSee($edited_product->quantity)
                    ->assertSee($edited_product->cart_quantity);
            if($edited_product->measure)
                $browser->assertSee($edited_product->measure);
            $browser->assertSee($edited_product->note)
                    ->assertRouteIs("shopping_list.show", compact("shopping_list"));
        });
    }

}
