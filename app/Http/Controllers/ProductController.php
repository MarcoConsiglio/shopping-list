<?php

namespace App\Http\Controllers;

use App\Product;
use App\ShoppingList;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ShoppingList $shopping_list)
    {
        $attributes = $request->validate([
            "name"          => "required|min:3|max:50",
            "brand"         => "max:50",
            "price"         => "nullable|numeric|min:0|max:1000",
            "quantity"      => "numeric|min:1|max:1000",
            "cart_quantity" => "nullable|numeric|min:0",
            "measure"       => "nullable|string",
            "note"          => "nullable|string"
        ]);
        $product = new Product($attributes);
        $shopping_list->products()->save($product);
        return redirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingList $shopping_list, Product $product)
    {
        $attributes = $request->validate([
            "name"          => "required|min:3|max:50",
            "brand"         => "max:50",
            "price"         => "nullable|numeric|min:0|max:1000",
            "quantity"      => "numeric|min:1|max:1000",
            "cart_quantity" => "nullable|numeric|min:0",
            "measure"       => "nullable|string",
            "note"          => "nullable|string"
        ]);
        $product->setRawAttributes($attributes)->saveOrFail();
        return redirect(route("shopping_list.show", $shopping_list));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
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
