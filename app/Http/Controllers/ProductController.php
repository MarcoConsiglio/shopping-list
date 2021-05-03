<?php

namespace App\Http\Controllers;

use App\Http\Requests\PutProduct;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
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
    public function store(StoreProduct $request, ShoppingList $shopping_list)
    {
        $product = new Product($request->validated());
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
    public function update(UpdateProduct $request, ShoppingList $shopping_list, Product $product)
    {
        $product->setRawAttributes($request->validated())->saveOrFail();
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
    public function addToCart(PutProduct $request, ShoppingList $shopping_list, Product $product) {
        $product->cart_quantity = $request->input("cart_quantity");
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
