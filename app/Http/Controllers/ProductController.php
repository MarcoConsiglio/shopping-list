<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Store a Product in a ShoppingList.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ShoppingList $shopping_list)
    {
        $attributes = $request->validate([
            "name"          => "required|min:3|max:50",
            "brand"         => "nullable|max:50",
            "price"         => "nullable|numeric|min:0|max:1000",
            "quantity"      => "numeric|min:1|max:1000",
            "cart_quantity" => "nullable|numeric|min:0",
            "measure"       => "nullable|string",
            "note"          => "nullable|string"
        ]);

        // Cast to float
        $attributes["price"] = (float)$attributes["price"];
        $attributes["quantity"] = (float)$attributes["quantity"];
        $attributes["cart_quantity"] = (float)$attributes["cart_quantity"];

        $product = new Product($attributes);
        $shopping_list->products()->save($product);
        return redirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Update a Product in a ShoppingList.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingList $shopping_list, Product $product)
    {
        $attributes = $request->validate([
            "name"          => "required|min:3|max:50",
            "brand"         => "max:50",
            "price"         => "nullable|numeric|min:0|max:1000",
            "quantity"      => "numeric|min:1|max:1000",
            "measure"       => "nullable|string",
            "note"          => "nullable|string"
        ]);

        // Cast to float
        $attributes["price"] = (float)$attributes["price"];
        $attributes["quantity"] = (float)$attributes["quantity"];
        $attributes["cart_quantity"] = $product->cart_quantity;
        // dd($attributes);
        $product->setRawAttributes($attributes)->saveOrFail();
        return redirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Add a quantity of a Product of a ShoppingList into the cart.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\ShoppingList $shopping_list
     * @param \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request, ShoppingList $shopping_list, Product $product) {
        $attributes = $request->validate([
            "cart_quantity" => "numeric|min:0"
        ]);
        $product->cart_quantity = $attributes["cart_quantity"];
        $product->saveOrFail();
        return redirect(route("shopping_list.show", compact("shopping_list")));
    }

    /**
     * Remove a Product from a ShoppingList.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingList $shopping_list, Product $product)
    {
        $product->delete();
        return redirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * All methods of this controller requires authentication.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth");
    }
}
