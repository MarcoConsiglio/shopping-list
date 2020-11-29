<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', "HomeController@index")->name('home');

Route::resource("shopping_list", "ShoppingListController")->only([
    "index", "show", "update", "destroy", "store"
]);

// Route::post("shopping-list/{shopping_list}/product/store", "ProductController@store")->name("shopping_list.product.store");
Route::resource("shopping_list.product", "ProductController")->only([
    "destroy", "store", "update"
]);
Route::post("/shopping_list/{shopping_list}/product/{product}/add-to-cart", "ProductController@addToCart")->name("shopping_list.product.add_to_cart");
