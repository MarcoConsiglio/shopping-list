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
     * A Dusk test example.
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
            $browser->assertSee($product->note);
            //     $browser->assertRedirect("shopping_list.show", compact("shopping_list"));
        });
    }
}
