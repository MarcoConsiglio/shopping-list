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

Route::get('/', function () {
    return view('welcome');
});

Route::resource("shopping_list", "ShoppingListController")->only([
    "index", "show", "update", "destroy", "store"
]);

// Route::post("shopping-list/{shopping_list}/product/store", "ProductController@store")->name("shopping_list.product.store");
Route::resource("shopping_list.product", "ProductController")->only([
    "destroy", "store"
]);
Route::get('/home', 'HomeController@index')->name('home');
