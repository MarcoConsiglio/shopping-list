<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\HomeController;
use App\ShoppingList;
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

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::resource("shopping_list", ShoppingListController::class)->except([
    "create", "edit"
]);

Route::resource("shopping_list.product", ProductController::class)->only([
    "destroy", "store", "update"
]);
Route::post("/shopping_list/{shopping_list}/product/{product}/add-to-cart", [ProductController::class, "addToCart"])->name("shopping_list.product.add_to_cart");

Route::get('/home', [HomeController::class, "index"])->name('home');
