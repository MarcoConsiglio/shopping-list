<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    /**
     * Display a collection of ShoppingLists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopping_lists = auth()->user()->shoppingLists;
        return view("shopping_list.index", compact("shopping_lists"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        auth()->user()->shoppingLists()->save(
            new ShoppingList($request->all())
        );
        return redirect(route("shopping_list.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShoppingList  $shopping_list
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingList $shopping_list)
    {
        return view("shopping_list.show", compact("shopping_list"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingList $shopping_list)
    {
        $shopping_list->update($request->all());
        return redirect(route("shopping_list.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingList $shopping_list)
    {
        $shopping_list->delete();
        return redirect(route("shopping_list.index"));
    }

    /**
     * All methods of this controller requires authentication.
     */
    public function __construct()
    {
        $this->middleware("auth");
    }
}
