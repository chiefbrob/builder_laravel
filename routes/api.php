<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(static function () {
    Route::get('/cart', Shop\GetShoppingCartController::class)->name('v1.cart');
    Route::post('/cart', Shop\AddItemToCartController::class)->name('v1.cart.add');
    Route::delete('/cart', Shop\RemoveItemFromCartController::class)->name('v1.cart.delete');
    Route::delete('/cart/empty', Shop\EmptyCartController::class)->name('v1.cart.empty');
    Route::get('/blog', Blog\GetBlogsController::class)->name('v1.blog.index');
    Route::post('/contact', Contact\CreateContactController::class)->name('v1.contact.create');
    Route::get('/products', Product\ProductsIndexController::class)->name('v1.product.index');
});