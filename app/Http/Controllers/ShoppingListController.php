<?php

namespace App\Http\Controllers;

use App\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopping_lists = auth()->user()->shopping_lists;
        return view("shopping_list.index", compact("shopping_lists"));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        auth()->user()->shopping_lists()->save(
            new ShoppingList($request->all())
        );
        return redirect(route("shopping_list.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShoppingList  $shopping_list
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingList $shopping_list)
    {
        return view("shopping_list.show", compact("shopping_list"));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\ShoppingList  $shoppingList
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(ShoppingList $shoppingList)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingList  $shoppingList
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
     * @param  \App\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();
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
